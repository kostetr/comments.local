var array = {
    'login': false,
    'pass': false,
    'pass-confirm': false,
    'surname': false,
    'name': false,
    'patronymic': false,
    'gender_id': false,
};
/*
 * ПРоверка на существование значения полей регистрации. 
 */
if ($("#login").val().length != "" && $("#surname").val().length != "" && $("#name").val().length != "" && $("#patronymic").val().length != "" && $("#gender_id").val().length != "") {
    fieldColor(1, 'login');
    fieldColor(1, 'surname');
    fieldColor(1, 'name');
    fieldColor(1, 'patronymic');
    fieldColor(1, 'gender_id');
}
/*
 * Проверки типов ошибок. Поле с ошибкой будет отмечено.
 */
if (passError.length !== 0) {
    fieldColor(0, 'pass');
    fieldColor(0, 'pass-confirm');
}
if (loginError.length !== 0) {
    fieldColor(0, 'login');
}
function fieldColor(erorColor, id) {
    if (erorColor == 1) {
        $('#' + id).css('background-color', '#90EE90');
        array[id] = true;
        arrayСheck();
    } else {
        $('#' + id).css('background-color', '#FFB6C1');
        array[id] = false;
        arrayСheck();
    }
}

/*
 * проверка массива. если 7шт. = true то удаляет атребут disabled у кнопки. Если  false то добавляет.
 */
function arrayСheck() {
    var result = 0;
    for (var key in array) {
        if (array[key]) {
            result++;
        }
    }
    if (result == 7) {
        $('#submit').removeAttr('disabled');
    } else {
        $('#submit').attr('disabled', 'disabled');
    }
}
/*
 * проверка пароля
 */
function passwordСheck() {
    if ($("#pass").val() != $("#pass-confirm").val() || $("#pass").val().length == 0 || $("#pass-confirm").val().length == 0 || $("#pass").val().length < 6 || $("#pass-confirm").val().length < 6) {
        fieldColor(0, 'pass');
        fieldColor(0, 'pass-confirm');
    } else {
        fieldColor(1, 'pass');
        fieldColor(1, 'pass-confirm');
    }
}
/*
 * Функция которая меняет цвет фона и записывает в массив true если значение валидное.
 */
function fieldColor(erorColor, id) {
    if (erorColor == 1) {
        $('#' + id).css('background-color', '#90EE90');
        array[id] = true;
        arrayСheck();
    } else {
        $('#' + id).css('background-color', '#FFB6C1');
        array[id] = false;
        arrayСheck();
    }
}

function  functionRegLoginChange() {
    if ($("#login").val().length < 5) {
        fieldColor(0, 'login');
    } else {
        fieldColor(1, 'login');
    }
};

function  functionRegSurnameChange(){ 
    if ($("#surname").val().length < 3) {
        fieldColor(0, 'surname');
    } else {
        fieldColor(1, 'surname');
    }
};
function  functionRegNameChange(){ 
    if ($("#name").val().length < 3) {
        fieldColor(0, 'name');
    } else {
        fieldColor(1, 'name');
    }
};
function  functionRegPatronymicChange(){ 
    if ($("#patronymic").val().length < 3) {
        fieldColor(0, 'patronymic');
    } else {
        fieldColor(1, 'patronymic');
    }
};

$("#gender_id").change(function () {
    if ($("#gender_id").val() > 0) {
        fieldColor(1, 'gender_id');
    } else {
        fieldColor(0, 'gender_id');
    }
});

