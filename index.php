<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Marks Analyzer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .result-box { background: #f9f9f9; padding: 15px; border-left: 5px solid #007bff; margin-top: 20px; }
        .alert-excellent { color: green; font-weight: bold; }
        .alert-improvement { color: red; font-weight: bold; }
        input[type="number"] { padding: 5px; margin-bottom: 10px; width: 100px; }
        button { padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Marks Analyzer</h2>

    <?php
    // ==========================================
    // STATE 3: PROCESSING MARKS & DISPLAYING RESULTS
    // ==========================================
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_marks'])) {
        $marks = $_POST['marks']; // Marks stored in an array [cite: 69]
        $num_students = count($marks);
        
        // Initialize calculation variables
        $total_marks = 0;
        $highest_mark = 0;
        $lowest_mark = 100; // Assuming marks are out of 100
        $average = 0;
        
        // Initialize challenge counters
        $above_50 = 0;
        $below_40 = 0;

        // 1. Foreach Loop: Processing marks (Total, Highest, Lowest) [cite: 45, 49, 50, 52]
        foreach ($marks as $mark) {
            $mark = (float)$mark;
            $total_marks += $mark;
            
            if ($mark > $highest_mark) {
                $highest_mark = $mark;
            }
            if ($mark < $lowest_mark) {
                $lowest_mark = $mark;
            }
        }

        // Calculate Average [cite: 46]
        $average = $total_marks / $num_students;

        echo "<div class='result-box'>";
        echo "<h3>Class Results</h3>";

        // 2. While Loop: Displaying summary and counting (Additional Challenge) [cite: 52, 82]
        $i = 0;
        while ($i < $num_students) {
            $current_mark = (float)$marks[$i];
            $student_number = $i + 1;
            
            // Display individual student marks [cite: 42, 55-59]
            echo "Student {$student_number}: {$current_mark} <br>";
            
            // Count for additional challenge [cite: 82-84]
            if ($current_mark > 50) {
                $above_50++;
            }
            if ($current_mark < 40) {
                $below_40++;
            }
            
            $i++;
        }

        echo "<h4>Summary</h4>";
        // Structured output format [cite: 60-63]
        echo "Total Marks: {$total_marks} <br>";
        echo "Class Average: " . number_format($average, 1) . " <br>";
        echo "Highest Mark: {$highest_mark} <br>";
        echo "Lowest Mark: {$lowest_mark} <br>";
        
        // Output for Additional Challenge [cite: 82-87]
        echo "<br><strong>Performance Metrics:</strong><br>";
        echo "Students scoring above 50: {$above_50} <br>";
        echo "Students scoring below 40: {$below_40} <br><br>";

        // Class performance message [cite: 85-87]
        if ($average >= 75) {
            echo "<span class='alert-excellent'>Excellent Class</span><br>";
        } elseif ($average < 50) {
            echo "<span class='alert-improvement'>Needs Improvement</span><br>";
        } else {
            echo "<span>Average Performance</span><br>";
        }

        echo "</div>";
        echo "<br><a href=''>Start Over</a>";
    }
    // ==========================================
    // STATE 2: DYNAMIC MARKS ENTRY FORM
    // ==========================================
    elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_num_students'])) {
        $num_students = (int)$_POST['num_students'];
        
        if ($num_students > 0) {
            echo "<h3>Enter Marks for {$num_students} Students</h3>";
            echo "<form method='POST' action=''>"; // Uses POST method 
            
            // 3. For Loop: Generating input fields dynamically [cite: 29, 38, 52]
            for ($i = 1; $i <= $num_students; $i++) {
                echo "<label>Student {$i} Marks:</label><br>";
                // Inputs are stored in the 'marks[]' array dynamically [cite: 67, 69]
                echo "<input type='number' name='marks[]' min='0' max='100' required><br>"; 
            }
            
            echo "<br><button type='submit' name='submit_marks'>Calculate Results</button>";
            echo "</form>";
        } else {
            echo "<p style='color:red;'>Please enter a valid number of students.</p>";
            echo "<a href=''>Go Back</a>";
        }
    }
    // ==========================================
    // STATE 1: FIRST FORM (NUMBER OF STUDENTS)
    // ==========================================
    else {
        ?>
        <form method="POST" action="">
            <label><strong>Number of Students:</strong></label><br>
            <input type="number" name="num_students" min="1" required>
            <br>
            <button type="submit" name="submit_num_students">Generate Fields</button>
        </form>
        <?php
    }
    ?>
</div>

</body>
</html>