<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Выбор даты и времени</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Выбор даты и времени</h1>
  <?php
    $errorMessage = "";
    $defaultDate = date('Y-m-d');
    $defaultTime = "";
    
    $currentTime = time();
    $currentTimeHours = date('H', $currentTime);

    if ($currentTimeHours < 15) {
      // Если текущее время меньше 15:00, устанавливаем на следующий день
      $defaultDate = date('Y-m-d', strtotime('+1 day'));
    } else {
      // Если текущее время больше или равно 15:00, устанавливаем на послезавтра
      $defaultDate = date('Y-m-d', strtotime('+2 day'));
    }
    $defaultTime = "08:30";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Получаем введенные данные
      $selectedDate = strtotime($_POST["date"]);
      $selectedTime = strtotime($_POST["time"]);

      // Условие 1: Пользователь не может выбрать дату записи на сегодня
      if (date('Y-m-d', $selectedDate) === date('Y-m-d', $currentTime)) {
        $errorMessage = "Выбрать дату выдачи на сегодня нельзя!";
      }

      // Условие 2: Пользователь не может выбрать дату записи на завтра, если текущее время больше 15:00
      if ($selectedDate - $currentTime < 24 * 60 * 60 && date('H', $currentTime) >= 15) {
        $errorMessage = "Вы не можете выбрать выдачу средств измерений на завтра, выберете на другой, подходящий для вас, день";
      }

      // Если ошибок нет, можно продолжать дальше с выбранной датой и временем
      if (empty($errorMessage)) {
        echo "<div class='selected_date'>Выбрана дата и время записи: " . date('Y-m-d', $selectedDate) . " " . date('H:i', $selectedTime) . "</div>";
      }
    }
  ?>
  <form action="" method="post">
    <label for="date">Дата:</label>
    <input type="date" id="date" name="date" value="<?php echo $defaultDate; ?>" required>
    <label for="time">Время:</label>
    <select id="time" name="time" required>
      <?php
        // Заполнение диапазона времени с интервалом в 15 минут
        $startTime = strtotime('08:30');
        $endTime = strtotime('17:15');
        $interval = 15 * 60;
        while ($startTime <= $endTime) {
          $optionValue = date('H:i', $startTime);
          echo '<option value="' . $optionValue . '"';
          if ($optionValue === $defaultTime) {
            echo ' selected';
          }
          echo '>' . $optionValue . '</option>';
          $startTime += $interval;
        }
      ?>
    </select>
    <button type="submit">Подтвердить</button>
  </form>
  <div style="color: red;"><?php echo $errorMessage; ?></div>
</body>
</html>
