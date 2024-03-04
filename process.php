
 <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $selectedDate = $_POST['date'];
  $selectedTime = $_POST['time'];
  
  $currentTime = strtotime('now');
  $selectedDateTime = strtotime($selectedDate . ' ' . $selectedTime);

  if (strtotime($selectedDate) === strtotime('today')) {
    echo "<script>alert('Выберите дату записи не на сегодня');</script>";
  } elseif ($currentTime >= strtotime('today 15:00') && strtotime($selectedDate) === strtotime('tomorrow')) {
    echo "<script>alert('Выберите дату записи не на завтра, если текущее время больше 15:00');</script>";
  } else {
    echo "Выбрана дата и время записи: " . date('Y-m-d H:i', $selectedDateTime);
    // Дальнейшие действия с выбранной датой и временем, например, отправка данных на сервер или обработка формы.
  }
}
?>
