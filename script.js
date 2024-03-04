function checkDateTime() {
  var selectedDate = new Date(document.getElementById('date').value);
  var currentTime = new Date();
  var selectedTime = document.getElementById('time').value;
  var selectedDateTime = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), selectedDate.getDate(), parseInt(selectedTime.substring(0, 2)), parseInt(selectedTime.substring(3)));

  // Условие 1: Пользователь не может выбрать дату записи на сегодня
  if (selectedDate.setHours(0, 0, 0, 0) === currentTime.setHours(0, 0, 0, 0)) {
    document.getElementById('error-message').innerText = "Ошибка: Выберите дату записи не на сегодня.";
    return false;
  }

  // Условие 2: Пользователь не может выбрать дату записи на завтра, если текущее время больше 15:00
  if (selectedDate - currentTime < 0 && currentTime.getHours() >= 15) {
    document.getElementById('error-message').innerText = "Ошибка: Выберите дату записи не на завтра, если текущее время больше 15:00.";
    return false;
  }

  // Если все условия выполнены, можно отправить форму
  return true;
}
