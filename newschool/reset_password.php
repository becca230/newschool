<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('include/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // STEP 1: Username submitted
    if (isset($_POST['username']) && !isset($_POST['answer']) && !isset($_POST['new_password'])) {
        $username = trim($_POST['username']);

        $stmt = $conn->prepare("SELECT security_question FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $question = $user['security_question'] ?? '';
            echo '
            <form id="answerForm" class="mt-3">
                <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Security Question:</label>
                    <p>' . htmlspecialchars($question) . '</p>
                </div>
                <div class="mb-3">
                    <input type="text" name="answer" placeholder="Your Answer" required class="form-control">
                </div>
                <button type="submit" class="btn btn-success w-100">Submit Answer</button>
            </form>

            <script>
            $(function(){
                $("#answerForm").on("submit", function(e){
                    e.preventDefault();
                    $.ajax({
                        url: "reset_password.php",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response){
                            $("#security_question").html(response);
                        },
                        error: function(xhr, status, error){
                            alert("⚠ Error verifying your answer: " + error);
                        }
                    });
                });
            });
            </script>
            ';
        } else {
            echo '<div class="alert alert-danger">User not found.</div>';
        }
    }

    // STEP 2: Security answer submitted
    elseif (isset($_POST['username'], $_POST['answer']) && !isset($_POST['new_password'])) {
        $username = trim($_POST['username']);
        $answer = trim($_POST['answer']);

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND security_answer = ?");
        $stmt->execute([$username, $answer]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo '
            <form id="newPasswordForm" class="mt-3">
                <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
                <div class="mb-3">
                    <input type="password" name="new_password" placeholder="New Password" required class="form-control">
                </div>
                <div class="mb-3">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100">Reset Password</button>
            </form>

            <script>
            $(function(){
                $("#newPasswordForm").on("submit", function(e){
                    e.preventDefault();
                    $.ajax({
                        url: "reset_password.php",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(response){
                            $("#security_question").html(response);
                        },
                        error: function(xhr, status, error){
                            alert("⚠ Error updating password: " + error);
                        }
                    });
                });
            });
            </script>
            ';
        } else {
            echo '<div class="alert alert-danger">Incorrect answer. Please try again.</div>';
        }
    }

    // STEP 3: Password reset
    elseif (isset($_POST['username'], $_POST['new_password'], $_POST['confirm_password'])) {
        $username = trim($_POST['username']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        if ($new_password !== $confirm_password) {
            echo '<div class="alert alert-danger">Passwords do not match.</div>';
            exit;
        }

        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hashed, $username]);

        echo '<div class="alert alert-success">✅ Password reset successful. You can now <a href="login.php">login</a>.</div>';
    }

    else {
        echo '<div class="alert alert-warning">Invalid request data.</div>';
    }
}
?>
