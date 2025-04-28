<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wedding Page</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Gwendolyn:wght@400;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet" />
</head>
<body>
    
<div class="form-group checkbox-group">
  <input type="checkbox" id="isPriority" name="isPriority">
  <label for="isPriority" class="checkbox-label">Mark as high priority</label>
</div>


<div class="form-group">
  <label class="radio-group-label">Priority Level:</label>
  <div class="radio-options">
    <div class="radio-option">
      <input type="radio" id="priorityHigh" name="priority" value="high">
      <label for="priorityHigh">High</label>
    </div>
    <div class="radio-option">
      <input type="radio" id="priorityMedium" name="priority" value="medium" checked>
      <label for="priorityMedium">Medium</label>
    </div>
    <div class="radio-option">
      <input type="radio" id="priorityLow" name="priority" value="low">
      <label for="priorityLow">Low</label>
    </div>
  </div>
</div>


<div class="form-group">
  <label for="priority" class="form-label">Priority Level:</label>
  <select id="priority" name="priority" class="form-select">
    <option value="high">High</option>
    <option value="medium" selected>Medium</option>
    <option value="low">Low</option>
  </select>
</div>

</body>
</html>