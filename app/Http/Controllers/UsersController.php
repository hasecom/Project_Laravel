<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    protected $status = false;//sessionでユーザ情報があるかないか、false=ない

/*====================================================================
Userのフロント画面
======================================================================*/
    /*=UserフロントGET=*/
    public function user_front() {
        return view('user/front');
    }
/*====================================================================
Userのログイン画面
======================================================================*/
    /*=UserログインGET=*/
    public function user_login() {
        return view('user/login');
    }
    /*=UserログインPOST=*/
    public function user_login_post(){
   
      if(isset($_POST['userid'])){
        $user_id_en = json_encode(['userid'=>$_POST['userid']]);
        $user_pass_en = json_encode(['userpassword'=>$_POST['userpassword']]);
        $user_id = json_decode($user_id_en,true);
        $user_pass = json_decode($user_pass_en,true);
      }
      if(isset($user_id_en)){//session記憶
        session()->put(['user_id' => $user_id['userid']]);
        session()->put(['user_pw' => $user_pass['userpassword']]);
   }

    }
/*====================================================================
Userの新規登録画面
======================================================================*/
    /*=User新規登録登録GET=*/
    public function sign_up(){
        //*アカウント新規登録、許可の配列（重複させない）
        $allow=[
        'chk_userid'=>true, //trueは許可されない
        'chk_useremail'=>true,
                ];
        if(session()->has('challenge_signup')){
            //ID,emailにダブりかあるかチェックする(falseならダブりなし)
            $user_id_chk = User::where('user_id',session()->get('temp_user_id'))->exists();
            $user_email_chk = User::where('mail',session()->get('temp_user_email'))->exists();
            if($user_id_chk == false)$allow['chk_userid']=false;
            if($user_email_chk == false)$allow['chk_useremail']=false;        
        }
        return view('user/sign_up',$allow);
    }
    /*=User新規登録登録POST=*/
    public function sign_up_post(){
        //TODO:hiddenで受け取り
        //?エンコード処理やnull値の処理はサーバでもやった方がいいかな？
        if(isset($_POST['userid'])){//*新規登録からアカウント情報を受け取れたか
            $user_name_en = json_encode(['username'=>$_POST['username']]);
            $user_id_en = json_encode(['userid'=>$_POST['userid']]);
            $user_email_en = json_encode(['useremail'=>$_POST['useremail']]);
            $user_pass_en = json_encode(['userpassword'=>$_POST['userpassword']]);
        
            $user_id = json_decode($user_id_en,true);
            $user_pass = json_decode($user_pass_en,true);
            $user_email = json_decode($user_email_en,true);
            $user_name = json_decode($user_name_en,true);
            session()->put(['challenge_signup'=>'challenge']);
            session()->put(['temp_user_id' => $user_id['userid']]);//sessionにput
            session()->put(['temp_user_pw' => $user_pass['userpassword']]);
            session()->put(['temp_user_email' => $user_email['useremail']]);
            session()->put(['temp_user_name' => $user_name['username']]);
        }else{
          $this->send_mail();
        }
      
    }
/* ====================================================================
Userのトップ画面
======================================================================*/
    /*=Userトップ画面=*/
    public function user_top() { 
        $user_userid =session()->get('user_id');//入力idをsessionに登録
        $user_userpw = session()->get('user_pw');//入力pwをsessionに登録
/*
TODO:DBにアクセスして認証チェック
*/
   $db_user_id = User::pluck("user_id");

   foreach ($db_user_id as $val) {//db内のuser_idを回す
        if($val === $user_userid){//idがdb内のidと一致するか
         $user_pass = User::where('user_id',$user_userid)->value('user_pw');
          if($user_userpw === $user_pass){//dbのpwと入力されたpwが一致するか
            $user_inner = User::where('user_id',$user_userid)->value('id');//内部ID取得
            //*主キーからfindでデータ取得->クラス内のメソッド参照(obj->arr)
            $user_info = $this->utf_chg(User::find($user_inner));
            var_dump($user_info);
        
            $this->status = true;//true=1(認証されたらtrue)
            $user_data = 
            [
            'user_info'=>$user_info,//ユーザ情報
            'user_status'=>$this->status//0は未ログイン
            ];
         return view('user/top',$user_data);
         }
     }
    }
    //認証が失敗したらログインページにリダイレクト
    return redirect()->route('login');
    }

    //*Userモデルでオブジェクトを配列に変換させる
    public function utf_chg($uni_arr){
        $utf8_arr = array();
        $utf8_arr = User::de($uni_arr);
        return $utf8_arr;
    }
    public function send_mail(){
        try{
            echo "a";
/*
TODO:仮登録のメール設定
メールへの接続

*/
//         mb_language("Ja");
//         mb_internal_encoding("UTF-8");
// $mailto = "hasetennis52@gmail.com";
// $subject = "PHPでのメール送信について";
// $content = "こんにちは。";
// $mailfrom="From:" .mb_encode_mimeheader("サンプル") ."<hasetennisth@gmail.com>";
// mb_send_mail($mailto, $subject, $content, $mailfrom);


        }catch(Exception $e){

        }

    }
}
