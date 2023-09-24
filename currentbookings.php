<!DOCTYPE html>
<html>
<head>
  <title>Current Bookings</title>
</head>
<body>
<div style="text-align: center;">
  <h1>Current Bookings</h1>
    <h2><a href='booking.php'>[Make a booking]</a><a href="index.php">[Return to main page]</a>
    </h2>

  
  <form>
    <label for="customer">Filter by Customer:</label>
    <select id="customer">
      <option value="">All Customers</option>
      <option value="customer1">Customer 1</option>
      <option value="customer2">Customer 2</option>
    </select>
    
    <label for="date">Filter by Date Period:</label>
    <input type="date" id="date" name="date">
    
    <input type="submit" value="Apply Filter">
  </form>
</div>
</body>
</html>

    