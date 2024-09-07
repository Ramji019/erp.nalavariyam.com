<?php
namespace App\Http\Controllers;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ForgotController extends Controller
{
    public function forgotpassword(Request $request) {
        $email=$request->email;
        $sql="select pas,full_name from users where email='$email'";
        $result=DB::select($sql);
        if(count($result)>0){
            $password=$result[0]->pas;
            $full_name=$result[0]->full_name;
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 2;
                $mail->isSMTP();
                $mail->Host = 'smtpout.secureserver.net';             
                $mail->SMTPAuth = true;
                $mail->Username = 'info@nalavariyam.com';   
                $mail->Password = "Ramji@019";       
                $mail->SMTPSecure = 'ssl';                  // encryption - ssl/tls
                $mail->Port = 465;                          // port - 587/465
                $mail->setFrom('info@nalavariyam.com', 'Nalavariyam');
                $mail->addAddress($email);
                $mail->Subject = "Forgot Password";
                $mail->Body    = "Dear $full_name \r\nYour password is $password \r\n \r\nRegards \r\nTeam Nalavariyam";
                if( !$mail->send() ) {
                    return back()->with("error", "Email not sent")->withErrors($mail->ErrorInfo);
                } else {
                    return back()->with("success", "Password sent to your email successfully");
                }
            } catch (Exception $e) {
               return back()->with('error',$e->getMessage());
           }
       }else{
            return back()->with("error", "Email not found in nalavariyam");
       }
        
   }
}
