<div class="form-group mb-3">
    <label for="question" class="form-label">Câu hỏi</label>
    <input type="text" name="question" id="question" class="form-control" value="{{ old('question', $faq->question ?? '') }}" required>
    @error('question')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    
</div>

<div class="form-group mb-3">
    <label for="answer" class="form-label">Câu trả lời</label>
    <textarea name="answer" id="answer" class="form-control" rows="5" required>{{ old('answer', $faq->answer ?? '') }}</textarea>
    @error('answer')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="sort_order" class="form-label">Thứ tự sắp xếp</label>
    <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" required>
    @error('sort_order')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="is_visible" id="is_visible" class="form-check-input" value="1" {{ old('is_visible', $faq->is_visible ?? true) ? 'checked' : '' }}>
    <label for="is_visible" class="form-check-label">Hiển thị ra ngoài trang chủ</label>
</div>

<button type="submit" class="btn btn-primary">Lưu lại</button>
<a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Hủy</a>


