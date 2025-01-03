<!-- app/Views/menu/select_day.php -->

<form action="index.php?controller=menu&action=showDay" method="POST">
    <label for="day">Day:</label>
    <select name="day" id="day">
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
        <option value="Saturday">Saturday</option>
        <option value="Sunday">Sunday</option>
    </select>
    <button type="submit">Show Menu</button>
</form>
