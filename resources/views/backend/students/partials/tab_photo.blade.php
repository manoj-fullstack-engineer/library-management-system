<style>
    .img-preview {
        display: block;
        margin-top: 1rem;
        max-width: 200px;
        height: auto;
        border-radius: 0.5rem;
        object-fit: cover;
        border: 1px solid #ccc;
    }
</style>

<div class="mb-3">
    <label for="photo" class="form-label">Upload Photo</label>
    <input class="form-control" type="file" name="photo" id="photo" accept="image/*">
    <img id="photoPreview" class="img-preview"
        src="{{ old('photo', isset($student->photo) ? asset('storage/' . $student->photo) : asset('default.png')) }}"
        alt="Photo Preview" />
</div>

{{-- Hidden compressed version --}}
<input type="hidden" name="compressed_photo" id="compressed_photo">

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');
            const compressedInput = document.getElementById('compressed_photo');

            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = new Image();
                        img.onload = function() {
                            const canvas = document.createElement('canvas');
                            const maxWidth = 600; // Adjust max width for compression
                            const scale = maxWidth / img.width;
                            canvas.width = maxWidth;
                            canvas.height = img.height * scale;

                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                            // Convert to base64 jpeg (quality: 0.7)
                            const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.7);
                            photoPreview.src = compressedDataUrl;
                            compressedInput.value = compressedDataUrl;
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush
