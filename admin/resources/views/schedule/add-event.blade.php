<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>일정 추가</title>
</head>

<body>
    <h1>일정 추가</h1>
    <form>
        <label for="title">일정 타이틀:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="start-date">시작 날짜:</label>
        <input type="date" id="start-date" name="start-date" required><br><br>
        <label for="end-date">끝나는 날짜:</label>
        <input type="date" id="end-date" name="end-date" required><br><br>
        <label for="time">시간:</label>
        <input type="time" id="time" name="time" required><br><br>
        <input type="submit" value="일정 추가">
    </form>
</body>

</html>
