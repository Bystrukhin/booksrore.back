<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function emailPasswordCode(Request $request)
    {
        $email = $request->input('email', '');
        $code = str_random(8);
        $date = date("Y-m-d H:i:s");
        $user = User::where('users.email', $email);

        $newCode = bcrypt($code);
        User::where('users.email', $request->input('email', ''))
            ->update(['password'=> $newCode, 'updated_at'=>$date]);

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'admin@archive.biz.ua';
        $mail->Password = 'password';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('admin@archive.biz.ua', 'Archive');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $bodyContent = '<h2>Hello!</h2>';
        $bodyContent .= '<div>Accordingly to your request, password was changed to </div>'. $code;
        $bodyContent .= '<br><p>Try to not forget it!</p>';
        $bodyContent .= '<div>Administration of archive.biz.ua</div>';

        $mail->Subject = 'Email from archive.biz.ua';
        $mail->Body = $bodyContent;

        $mail->send();

        if (!$user) {
        return response()->json(['No user found'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['New password was sent to ' . $email], Response::HTTP_OK);
    }
}
