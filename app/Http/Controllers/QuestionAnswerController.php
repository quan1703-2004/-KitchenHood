<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionAnswerController extends Controller
{
    /**
     * Hiển thị trang hỏi đáp
     */
    public function index()
    {
        try {
            // Lấy tất cả câu hỏi với answers, sắp xếp theo thời gian mới nhất
            $questions = Question::with(['user', 'answers.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // Lấy danh sách danh mục
            $categories = Question::getCategories();

            return view('customer.question-answer.index', compact('questions', 'categories'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị trang hỏi đáp: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải trang hỏi đáp.');
        }
    }

    /**
     * Lưu câu hỏi mới
     */
    public function store(Request $request)
    {
        try {
            // Log request để debug
            Log::info('Question store request:', $request->all());
            
            // Validation rules
            $rules = [
                'title' => 'required|string|min:5|max:255',
                'category' => 'required|string|in:' . implode(',', array_keys(Question::getCategories())),
                'content' => 'required|string|min:10|max:2000',
            ];
            
            // Custom messages
            $messages = [
                'title.required' => 'Vui lòng nhập tiêu đề câu hỏi.',
                'title.min' => 'Tiêu đề phải có ít nhất 5 ký tự.',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
                'category.required' => 'Vui lòng chọn danh mục câu hỏi.',
                'category.in' => 'Danh mục không hợp lệ.',
                'content.required' => 'Vui lòng nhập nội dung câu hỏi.',
                'content.min' => 'Nội dung phải có ít nhất 10 ký tự.',
                'content.max' => 'Nội dung không được vượt quá 2000 ký tự.',
            ];
            
            $request->validate($rules, $messages);

            // Kiểm tra user đã đăng nhập chưa
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để đặt câu hỏi.'
                ], 401);
            }

            // Tạo câu hỏi
            $question = Question::create([
                'user_id' => Auth::id(),
                'title' => trim($request->input('title')),
                'category' => $request->input('category'),
                'content' => trim($request->input('content')),
                'is_answered' => 0
            ]);

            Log::info('Question created successfully:', ['id' => $question->id]);

            return response()->json([
                'success' => true,
                'message' => 'Câu hỏi đã được gửi thành công!',
                'question' => $question->load('user')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lưu câu hỏi: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi câu hỏi. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Cập nhật câu hỏi (chỉ chủ sở hữu và chưa có trả lời admin)
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        $validated = $request->validate([
            'title' => 'required|string|min:5|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(Question::getCategories())),
            'content' => 'required|string|min:10|max:2000',
        ]);

        $question->update([
            'title' => trim($validated['title']),
            'category' => $validated['category'],
            'content' => trim($validated['content']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật câu hỏi thành công.',
            'question' => $question->fresh()->load('user')
        ]);
    }

    /**
     * Lấy danh sách câu hỏi chưa trả lời (cho admin)
     */
    public function getUnansweredQuestions()
    {
        try {
            $unansweredQuestions = Question::unanswered()
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'questions' => $unansweredQuestions,
                'count' => $unansweredQuestions->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy câu hỏi chưa trả lời: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải câu hỏi.'
            ], 500);
        }
    }

    /**
     * Lấy số lượng câu hỏi chưa trả lời (cho admin)
     */
    public function getUnansweredCount()
    {
        try {
            $count = Question::unanswered()->count();

            return response()->json([
                'success' => true,
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy số lượng câu hỏi chưa trả lời: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải dữ liệu.'
            ], 500);
        }
    }

    /**
     * Trả lời câu hỏi (cho admin)
     */
    public function answer(Request $request, Question $question)
    {
        try {
            // Log request để debug
            Log::info('=== ANSWER REQUEST START ===');
            Log::info('Question ID: ' . $question->id);
            Log::info('User ID: ' . Auth::id());
            Log::info('User Role: ' . (Auth::user() ? Auth::user()->role : 'null'));
            Log::info('Request Content: ' . $request->input('content'));
            Log::info('All Request Data: ', $request->all());
            Log::info('Request Headers: ', $request->headers->all());
            
            // Kiểm tra user có đăng nhập không
            if (!Auth::check()) {
                Log::warning('User not authenticated');
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để trả lời câu hỏi.'
                ], 401);
            }
            
            // Kiểm tra user có quyền admin không
            if (Auth::user()->role !== 'admin') {
                Log::warning('Non-admin user tried to answer question', [
                    'user_id' => Auth::id(),
                    'user_role' => Auth::user()->role,
                    'question_id' => $question->id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền trả lời câu hỏi.'
                ], 403);
            }
            
            $request->validate([
                'content' => 'required|string|min:5|max:2000',
            ], [
                'content.required' => 'Vui lòng nhập nội dung trả lời.',
                'content.min' => 'Nội dung trả lời phải có ít nhất 5 ký tự.',
                'content.max' => 'Nội dung trả lời không được vượt quá 2000 ký tự.',
            ]);

            Log::info('Validation passed, starting database transaction...');

            DB::beginTransaction();

            // Tạo câu trả lời
            $answerData = [
                'question_id' => $question->id,
                'user_id' => Auth::id(),
                'content' => trim($request->input('content'))
            ];
            
            Log::info('Creating answer with data: ', $answerData);
            
            $answer = Answer::create($answerData);

            Log::info('Answer created successfully:', [
                'answer_id' => $answer->id,
                'question_id' => $answer->question_id,
                'user_id' => $answer->user_id,
                'content_length' => strlen($answer->content)
            ]);

            // Cập nhật trạng thái câu hỏi
            Log::info('Updating question status to answered...');
            $question->update(['is_answered' => 1]);
            Log::info('Question status updated');

            DB::commit();
            Log::info('Database transaction committed');

            Log::info('Answer process completed successfully:', ['answer_id' => $answer->id]);

            return response()->json([
                'success' => true,
                'message' => 'Trả lời đã được gửi thành công!',
                'answer' => $answer->load('user')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in answer method: ' . $e->getMessage());
            Log::error('Exception file: ' . $e->getFile());
            Log::error('Exception line: ' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi trả lời. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Hiển thị trang quản lý hỏi đáp cho admin
     */
    public function adminIndex(Request $request)
    {
        try {
            // Lấy các tham số lọc
            $status = $request->get('status', 'all');
            $category = $request->get('category', 'all');
            $search = $request->get('search', '');
            $page = $request->get('page', 1);

            // Query cơ bản
            $unansweredQuery = Question::unanswered()->with('user');
            $answeredQuery = Question::answered()->with(['user', 'answers.user']);

            // Áp dụng bộ lọc danh mục
            if ($category !== 'all') {
                $unansweredQuery->where('category', $category);
                $answeredQuery->where('category', $category);
            }

            // Áp dụng tìm kiếm
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $unansweredQuery->where(function($query) use ($searchTerm) {
                    $query->where('title', 'like', $searchTerm)
                          ->orWhere('content', 'like', $searchTerm)
                          ->orWhereHas('user', function($q) use ($searchTerm) {
                              $q->where('name', 'like', $searchTerm)
                                ->orWhere('email', 'like', $searchTerm);
                          });
                });
                
                $answeredQuery->where(function($query) use ($searchTerm) {
                    $query->where('title', 'like', $searchTerm)
                          ->orWhere('content', 'like', $searchTerm)
                          ->orWhereHas('user', function($q) use ($searchTerm) {
                              $q->where('name', 'like', $searchTerm)
                                ->orWhere('email', 'like', $searchTerm);
                          });
                });
            }

            // Sắp xếp theo thời gian mới nhất
            $unansweredQuery->orderBy('created_at', 'desc');
            $answeredQuery->orderBy('created_at', 'desc');

            // Lấy dữ liệu theo trạng thái
            if ($status === 'unanswered') {
                $unansweredQuestions = $unansweredQuery->get();
                $answeredQuestions = collect();
            } elseif ($status === 'answered') {
                $unansweredQuestions = collect();
                $answeredQuestions = $answeredQuery->get();
            } else {
                $unansweredQuestions = $unansweredQuery->get();
                $answeredQuestions = $answeredQuery->get();
            }

            // Lấy câu hỏi của admin hiện tại
            $myQuestions = Question::where('user_id', Auth::id())
                ->with(['user', 'answers.user'])
                ->orderBy('created_at', 'desc')
                ->get();

            $categories = Question::getCategories();

            // Nếu là AJAX request, trả về JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'unansweredQuestions' => $unansweredQuestions,
                    'answeredQuestions' => $answeredQuestions,
                    'myQuestions' => $myQuestions,
                    'categories' => $categories,
                    'totalUnanswered' => $unansweredQuestions->count(),
                    'totalAnswered' => $answeredQuestions->count(),
                    'totalQuestions' => $unansweredQuestions->count() + $answeredQuestions->count()
                ]);
            }

            return view('admin.question-answer.index', compact('unansweredQuestions', 'answeredQuestions', 'myQuestions', 'categories'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi hiển thị trang admin hỏi đáp: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi tải dữ liệu.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tải trang quản lý hỏi đáp.');
        }
    }

    /**
     * Lấy thống kê hỏi đáp cho dashboard
     */
    public function getStatistics()
    {
        try {
            $totalQuestions = Question::count();
            $unansweredQuestions = Question::unanswered()->count();
            $answeredQuestions = Question::answered()->count();
            $answerRate = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100, 1) : 0;

            // Thống kê theo danh mục
            $categoryStats = Question::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get()
                ->keyBy('category');

            // Câu hỏi mới nhất (5 câu hỏi gần nhất)
            $latestQuestions = Question::with('user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return response()->json([
                'success' => true,
                'statistics' => [
                    'totalQuestions' => $totalQuestions,
                    'unansweredQuestions' => $unansweredQuestions,
                    'answeredQuestions' => $answeredQuestions,
                    'answerRate' => $answerRate,
                    'categoryStats' => $categoryStats,
                    'latestQuestions' => $latestQuestions
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy thống kê hỏi đáp: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải thống kê.'
            ], 500);
        }
    }

    /**
     * Xóa câu hỏi (chỉ admin)
     */
    public function destroy(Question $question)
    {
        try {
            // Kiểm tra quyền admin
            if (Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa câu hỏi.'
                ], 403);
            }

            // Xóa các câu trả lời liên quan
            $question->answers()->delete();
            
            // Xóa câu hỏi
            $question->delete();

            return response()->json([
                'success' => true,
                'message' => 'Câu hỏi đã được xóa thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa câu hỏi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa câu hỏi.'
            ], 500);
        }
    }

    /**
     * Xóa câu trả lời (chỉ admin)
     */
    public function destroyAnswer(Answer $answer)
    {
        try {
            // Kiểm tra quyền admin
            if (Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa câu trả lời.'
                ], 403);
            }

            $question = $answer->question;
            
            // Xóa câu trả lời
            $answer->delete();
            
            // Kiểm tra xem còn câu trả lời nào khác không
            $remainingAnswers = $question->answers()->count();
            if ($remainingAnswers === 0) {
                // Nếu không còn câu trả lời nào, đánh dấu câu hỏi là chưa trả lời
                $question->update(['is_answered' => 0]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Câu trả lời đã được xóa thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa câu trả lời: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa câu trả lời.'
            ], 500);
        }
    }
}
