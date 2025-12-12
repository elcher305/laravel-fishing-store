$(document).ready(function() {
    // Добавление характеристик
    $('#add-spec').click(function() {
        const newRow = $(`
            <div class="row g-2 mb-2 specification-row">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="spec_keys[]" placeholder="Например: Материал">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="spec_values[]" placeholder="Например: Нержавеющая сталь">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger w-100 remove-spec">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);

        $('#specifications-container').append(newRow);
        updateRemoveButtons();
    });

    // Удаление характеристик
    $(document).on('click', '.remove-spec', function() {
        if ($('.specification-row').length > 1) {
            $(this).closest('.specification-row').remove();
            updateRemoveButtons();
        }
    });

    // Обновление состояния кнопок удаления
    function updateRemoveButtons() {
        $('.remove-spec').prop('disabled', $('.specification-row').length <= 1);
    }

    // Превью изображения
    $('#image').change(function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').html(`
                    <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">
                    <p class="small text-muted mt-2">Предпросмотр</p>
                `);
            };
            reader.readAsDataURL(file);
        }
    });

    updateRemoveButtons();
});
