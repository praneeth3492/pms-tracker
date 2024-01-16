<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Tracker Checker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <style>
        .ui-datepicker-calendar .ui-state-disabled > span {
            opacity: 0.35;
        }
        #checkButton:disabled {
            background-color: grey;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Monthly Tracker Checker</h2>

    <button id="checkButton" onclick="toggleCheck()">Not Checked</button>

    <div id="datepicker"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker({
                defaultDate: new Date(),
                beforeShowDay: function(date) {
                    var currentDate = new Date();
                    if (date.getDate() === currentDate.getDate() &&
                        date.getMonth() === currentDate.getMonth() &&
                        date.getFullYear() === currentDate.getFullYear()) {
                        return [true];
                    }
                    return [false];
                }
            });
        });

        function toggleCheck() {
            var button = document.getElementById('checkButton');
            button.innerHTML = 'Checked';
            button.disabled = true;
        }
    </script>
</body>
</html>
