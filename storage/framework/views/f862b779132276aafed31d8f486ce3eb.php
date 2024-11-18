<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <style type="text/css">
        body,
        table,
        td {
            font-family: Helvetica, Arial, sans-serif !important;
        }

        a {
            text-decoration: none;
        }

        img {
            -ms-interpolation-mode: bicubic;
            width: 100%;
            height: auto;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        .card {
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            padding: 40px;
            background-color: #ffffff;
        }

        .footer {
            text-align: center;
            color: #718096;
            padding: 20px;
        }

        .message {
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>

<body style="margin: 0; padding: 0; background-color: #f7fafc;">
    <table class="container" role="presentation">
        <tr>
            <td class="header">

                <center>

                    <img src="https://scontent.fmnl17-6.fna.fbcdn.net/v/t39.30808-6/399434519_122118450656079042_7601433698559540672_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFganLRFe4as7VGZgSGFL4uCAaG5sSOyxIIBobmxI7LEpL9o-leIwHBfb0dSo2CXZiUCtiVG_p7pmpGcYIQ4OZx&_nc_ohc=g3XLpabDWD8Q7kNvgFJ8sOr&_nc_ht=scontent.fmnl17-6.fna&_nc_gid=APIjMbQRECWqLmHx_rTeoGW&oh=00_AYDB4i_N34rfiXp3-uquOiBdqQj1yvBzeRKGx-p3xvMung&oe=671254EC"
                        style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 150px; border-style: none; border-width: 0;"
                        width="96" alt="Logo">
                </center>

            </td>
        </tr>
        <tr>
            <td>
                <div class="card">
                    <h1 style="font-size: 28px; font-weight: 700; margin: 0;">Notification</h1>
                    <p>Thank you for reaching out to us. Below is your message:</p>
                    <div class="message"><?php echo e($mailMessage); ?><b>Total Start Points: <?php echo e($totalStarPoints); ?></b></div>
                    <div class="footer"><?php echo e($email); ?><br>Best regards,<br><a
                            href="https://tripidkard.com">Tripidkard</a></div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\laravel-project\tripidkard-laravel\resources\views/mail/pointOrder.blade.php ENDPATH**/ ?>