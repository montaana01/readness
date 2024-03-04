<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Выбор даты и времени</title>
  <link rel="icon" type="image/x-icon" href="/img/favicon.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Выбор даты и времени</h1>
    <?php
      $errorMessage = "";
      $selectedDate = "";
      
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Получаем введенные данные
        $selectedDate = $_POST["date"];
        $selectedTime = strtotime($_POST["time"]);

        // Получаем текущие дату и время
        $currentTime = time();


        if (strtotime($selectedDate) < strtotime('today')) {
          $errorMessage = "Нельзя выбрать прошедшую дату!";
        } elseif (date('Y-m-d', strtotime($selectedDate)) === date('Y-m-d', $currentTime)) {// Условие: Пользователь не может выбрать дату и время выдачи на сегодня
          $errorMessage = "Выбрать дату выдачи на сегодня нельзя!";
        } elseif (strtotime($selectedDate) - $currentTime < 24 * 60 * 60 && date('H', $currentTime) >= 15) { // Условие 2: Пользователь не может выбрать дату записи на завтра, если текущее время больше 15:00
          $errorMessage = "Вы не можете выбрать выдачу средств измерений на завтра, выберете на другой, подходящий для вас, день!";
        }

        // Если ошибок нет, можно продолжать дальше с выбранной датой и временем
        if (empty($errorMessage)) {
          echo "<div class='selected_date'>Выбрана дата и время записи: " . date('Y-m-d', strtotime($selectedDate)). " " . date('H:i', strtotime($selectedTime)) . "</div>";
        }
      }
    ?>
    <form action="" method="post">
      <label for="date">Дата:</label>
      <input type="date" id="date" name="date" value="<?php echo $selectedDate; ?>" required>
      <label for="time">Время:</label>
      <select id="time" name="time" required>
        <?php
          // Заполнение диапазона времени с интервалом в 15 минут
          $startTime = strtotime('08:30');
          $endTime = strtotime('17:15');
          $interval = 15 * 60;
          while ($startTime <= $endTime) {
            echo '<option value="' . date('H:i', $startTime) . '">' . date('H:i', $startTime) . '</option>';
            $startTime += $interval;
          }
        ?>
      </select>
      <button type="submit">Подтвердить</button>
    </form>
    <div class="error-message"><?php echo $errorMessage; ?></div>
  </div>
</body>
</html>


