<?php
// Handle POST request from AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
    $userMessage = strtolower(trim($_POST['text']));
    $response = "";

    // Expanded response logic
    switch ($userMessage) {
        // Greetings & Basics
        case "hi":
        case "hello":
        case "hey":
            $response = "Hello! How can I assist you with your digital products today?";
            break;
        case "how are you":
            $response = "I'm just a bot, but I'm doing well! How can I help you today?";
            break;
        case "bye":
        case "goodbye":
            $response = "Thanks for visiting! Come back anytime.";
            break;

        // Navigation Help
        case "where is cart":
        case "how to view my cart":
            $response = "You can find the cart at the top of the homepage in the header section.";
            break;
        case "where is product":
        case "how to browse products":
            $response = "All products are listed on the homepage in the body section.";
            break;
        case "how to checkout":
            $response = "Go to your cart, then click on the 'Checkout' button and follow the steps.";
            break;
        case "where is my account":
        case "how to access my account":
            $response = "Click on the user icon in the top-right corner to access your account.";
            break;

        // Orders & Payment
        case "how do i place an order":
            $response = "Add a product to your cart, go to checkout, fill in your details, and make the payment.";
            break;
        case "what payment methods are accepted":
            $response = "We accept credit/debit cards, PayPal, and other digital wallets.";
            break;
        case "is payment secure":
            $response = "Yes, all payments are encrypted and processed through secure gateways.";
            break;

        // Downloads
        case "how to download purchased product":
        case "where is my download":
            $response = "After purchase, go to 'My Account' → 'Downloads' to access your files.";
            break;
        case "how long are downloads available":
            $response = "Downloads are available indefinitely from your account unless otherwise stated.";
            break;

        // Licensing
        case "do products have license":
            $response = "Yes, each product comes with a usage license. Details are on the product page.";
            break;
        case "can i resell downloaded product":
            $response = "No, reselling or redistributing downloaded products is not allowed.";
            break;

        // Technical Issues
        case "my download is not working":
            $response = "Please try re-downloading from your account. If the issue continues, contact support.";
            break;
        case "i didn't receive confirmation email":
            $response = "Please check your spam folder. If not found, contact our support team.";
            break;

        // Support
        case "how to contact support":
            $response = "You can reach out via the 'Contact Us' page or email support@yourwebsite.com.";
            break;
        case "is support available 24/7":
            $response = "Support is available Monday to Friday, 9 AM to 6 PM (GMT).";
            break;

        default:
            $response = "Sorry, I didn't understand that. Could you please rephrase or ask something else?";
            break;
    }

    echo $response;
    exit;
}
?>

<!-- The rest of your chatbot frontend (unchanged) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot in PHP</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        /* Inline styling in case style.css is missing */
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 0;
            margin: 0;
        }
        .wrapper {
            width: 400px;
            margin: 50px auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .title {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 20px;
        }
        .form {
            padding: 10px;
            height: 300px;
            overflow-y: auto;
            border-bottom: 1px solid #ccc;
        }
        .inbox {
            display: flex;
            margin: 10px 0;
        }
        .user-inbox .msg-header,
        .bot-inbox .msg-header {
            max-width: 80%;
            background: #e1f0ff;
            padding: 10px;
            border-radius: 10px;
        }
        .user-inbox {
            justify-content: flex-end;
        }
        .bot-inbox .icon {
            margin-right: 10px;
            color: #007bff;
        }
        .typing-field {
            display: flex;
            padding: 10px;
        }
        .input-data input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
        }
        .input-data button {
            padding: 10px 20px;
            margin-left: 10px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Simple Online Chatbot</div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, how can I help you?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" placeholder="Type something here..." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#send-btn").on("click", function(){
                let value = $("#data").val().trim();
                if (value === '') return;

                let userMsg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + value + '</p></div></div>';
                $(".form").append(userMsg);
                $("#data").val('');

                $.ajax({
                    url: 'bot.php',
                    type: 'POST',
                    data: { text: value },
                    success: function(result){
                        let botReply = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + result + '</p></div></div>';
                        $(".form").append(botReply);
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });
        });
    </script>
</body>
</html>
