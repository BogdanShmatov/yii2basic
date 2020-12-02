$(document).ready(function() {
    $('#course-form').on('beforeSubmit', function() {
        // Получаем объект формы
        var $courseForm = $(this);
        // отправляем данные на сервер
        $.ajax({
            // Метод отправки данных (тип запроса)
            type : $courseForm.attr('method'),
            // URL для отправки запроса
            url : $courseForm.attr('action'),
            // Данные формы
            data : $courseForm.serializeArray()
        }).done(function(data) {
            if (data.error == null) {
                // Если ответ сервера успешно получен
                $("#output").text(data.data.text)
            } else {
                // Если при обработке данных на сервере произошла ошибка
                $("#output").text(data.error)
            }
        }).fail(function() {
            // Если произошла ошибка при отправке запроса
            $("#output").text("error3");
        })
        // Запрещаем прямую отправку данных из формы
        return false;
    })
})