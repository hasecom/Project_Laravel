<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Temp_User;
use Illuminate\Support\Facades\Storage;


class UsersController extends Controller
{

    //TODO:【バグ】新規作成で仮登録完了後にもう一度入力すると登録できない
    protected $status = false;//sessionでユーザ情報があるかないか、false=ない
  
/*====================================================================
Userのフロント画面
======================================================================*/
    /*=UserフロントGET=*/
    public function user_front() {
        return view('user/front');
    }
    /*=UserフロントPOST=*/
    public function user_front_post(){
     //TODO:削除する   
   // $sample_data = $_POST['files'];
   // $img = $_POST['files'];
   // $img = str_replace('data:image/jpeg;base64,', '', $img);
    //$img = str_replace(' ', '+', $img);
   // $fileData = base64_decode($img);
    //saving
    // $fileName = 'photo.jpg';
   // Storage::put('public/photo.jpg', $fileData);
    //$path = Storage::disk('s3')->put('public/aaa.jpg', $fileData);


   // $contents = Storage::disk('s3')->get('face2.jpg'); 
   // return  base64_encode($contents);


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

          if(isset($_POST['first_token'])){//仮登録のURLを踏んだ処理
              //本登録はfirst_tokenを持っていて仮登録DBと比較&&token_flgが1ならば 
              //TODO:token_flgを24h?で無効にする処理を書かなければならぬ。
            $token_falsehood=Temp_User::where('token',$_POST['first_token'])->exists();
            $token_flg=Temp_User::where('token',$_POST['first_token'])->value('token_flag');
           if($token_falsehood == true && $token_flg == 1){//tokenがDB内のtokenにあれば
              $temp_id = Temp_User::where('token',$_POST['first_token'])->value('temp_id');
              $temp_pw = Temp_User::where('token',$_POST['first_token'])->value('temp_pw');
              $temp_name = Temp_User::where('token',$_POST['first_token'])->value('temp_name'); 
              $temp_mail = Temp_User::where('token',$_POST['first_token'])->value('temp_email'); 
              $temp_inner_id = Temp_User::where('token',$_POST['first_token'])->value('id'); 

        /*=本登録DBに保存しやす=*/
        try{
          $sign_up_user = new User;
          $sign_up_user->user_id = $temp_id;
          $sign_up_user->user_pw =$temp_pw;
          $sign_up_user->user_name = $temp_name;
          $sign_up_user->mail = $temp_mail;
          $sign_up_user->save();
        /*=temp_userのtokenを無効にする=*/
          $temp_save = Temp_User::findOrFail($temp_inner_id);
          $temp_save->token_flag = 0;
          $temp_save->save();
        }catch(Exception $e){

        }

           }
          }
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
            //*TEMP_ID,EMAILと本登録のIDとEMAILを合わせて比較
            //ID,emailにダブりかあるかチェックする(falseならダブりなし)
            $user_id_chk = User::where('user_id',session()->get('temp_user_id'))->exists();
            $user_email_chk = User::where('mail',session()->get('temp_user_email'))->exists();
            $temp_id_chk = Temp_User::where('token_flag',1)->where('temp_id',session()->get('temp_user_id'))->exists();
            $temp_email_chk = Temp_User::where('temp_email',session()->get('temp_user_email'))->exists();
            /*仮登録と本登録のDBから重複が無いかチェックをして一致しなければ
            $allow配列にfalseを返す。IDかメアドどちらが重複しているか分かるように
            IDとメールの項目を作成。->
            //TODO:vue内でユーザが分かるように表示させる　
            */
            if($user_id_chk == false && $temp_id_chk == false)$allow['chk_userid']=false;
            if($user_email_chk == false && $temp_email_chk == false)$allow['chk_useremail']=false;   
        }
        return view('user/sign_up',$allow);
    }
    /*=User新規登録登録POST=*/
    public function sign_up_post(){
        $allow=[
            'chk_userid'=>true, //trueは許可されない
            'chk_useremail'=>true,
                    ];
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
            if($user_id['userid'] != "" || $user_pass['userpassword'] != "" || $user_email['useremail'] !="" || $user_name['username'] != "")
            {
            session()->put(['challenge_signup'=>'challenge']);
            session()->put(['temp_user_id' => $user_id['userid']]);//sessionにput
            session()->put(['temp_user_pw' => $user_pass['userpassword']]);
            session()->put(['temp_user_email' => $user_email['useremail']]);
            session()->put(['temp_user_name' => $user_name['username']]);
            
            }else{
               
                session()->forget('temp_user_id');
                session()->forget('temp_user_pw');
                session()->forget('temp_user_email');
                session()->forget('temp_user_name');
                session()->forget('challenge_signup');
             
            }
        }else{
        /*=新規登録入力後にメールが送られる処理=*/
          $this->send_mail();

          $user_data = 
          [
          'status'=>true,
          'email'=>session()->get('temp_user_email'),
          'token'=>''
          ];
          /*=仮登録DBに保存しやす=*/
          $temp_sign_up_user = new Temp_User;
          $temp_sign_up_user->temp_id = session()->get('temp_user_id');
          $temp_sign_up_user->temp_pw = session()->get('temp_user_pw');
          $temp_sign_up_user->temp_name = session()->get('temp_user_name');
          $temp_sign_up_user->temp_email = session()->get('temp_user_email');
          $temp_sign_up_user->token = str_random(32);
          $temp_sign_up_user->save();

          $user_data['token'] = Temp_User::where('temp_id',session()->get('temp_user_id'))->value('token');

          /*=仮登録用のsessionはここでサヨナラ=*/
          session()->forget('temp_user_id');
          session()->forget('temp_user_pw');
          session()->forget('temp_user_email');
          session()->forget('temp_user_name');
          session()->forget('challenge_signup');

        

          //sign_up2のvueにメールアドレスとステータスを返すのだお
          return $user_data;
        }
     
        if(session()->has('challenge_signup')){
            //*TEMP_ID,EMAILと本登録のIDとEMAILを合わせて比較
            //ID,emailにダブりかあるかチェックする(falseならダブりなし)
            $user_id_chk = User::where('user_id',session()->get('temp_user_id'))->exists();
            $user_email_chk = User::where('mail',session()->get('temp_user_email'))->exists();
            $temp_id_chk = Temp_User::where('token_flag',1)->where('temp_id',session()->get('temp_user_id'))->exists();
            $temp_email_chk = Temp_User::where('temp_email',session()->get('temp_user_email'))->exists();
            /*仮登録と本登録のDBから重複が無いかチェックをして一致しなければ
            $allow配列にfalseを返す。IDかメアドどちらが重複しているか分かるように
            IDとメールの項目を作成。->
            //TODO:vue内でユーザが分かるように表示させる　
            */
        
            if($user_id_chk == false && $temp_id_chk == false)$allow['chk_userid']=false;
            if($user_email_chk == false && $temp_email_chk == false)$allow['chk_useremail']=false;   
        
        }
        return $allow;

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
            $account_info = $this->utf_chg(User::find($user_inner,
            array(
                'id',
                'user_id',
                'user_name',
                'si_text',
                'icon_path',
                'icon_name',
                'point'
            )));
        
            $this->status = true;//true=1(認証されたらtrue)
            $user_data = 
            [
            'account_info'=>$account_info,//ユーザ情報
            'user_status'=>$this->status//0は未ログイン
            ];
         return view('user/top',$user_data);
         }
     }
    }
    //認証が失敗したらログインページにリダイレクト
    return redirect()->route('login');
    }
/* ====================================================================
仮登録から本登録へのログイン画面
======================================================================*/
    /*=User本登録ログインGET=*/
    public function main_registration(){
        if(isset($_GET['token'])){
            $flag=Temp_User::where('token',$_GET['token'])->value('token_flag');
            if($flag == 1){
                $token_arr = ["token"=>$_GET['token']];
                return view('user/login',$token_arr);
            }
        }
        //認証が失敗したらログインページにリダイレクト
        return redirect()->route('login');
             
    }
/* ====================================================================
アカウント情報を送るデータ
======================================================================*/
   
    public function account_data(){
    
        if(isset($this->user_top()->account_info)){
            $account_data =  $this->user_top()->account_info;
            return $account_data;
         }else{
 //?account_dataがない場合（ログインしてないとき)の表示？リダイレクトどうするか
         }
        
    }
/* ====================================================================
誰がログインしてるか->ログインしているユーザの情報を返す
======================================================================*/
    public function account_chk_data(){
        if(isset($this->user_top()->account_info)){
           $account_chk =  $this->user_top()->account_info;
            $account_chk_arr = [
                "user_id" => $account_chk['user_id'],
                "id"=>$account_chk['id'],
                "icon_path"=>$account_chk['icon_path'],
                "icon_name"=>$account_chk['icon_name'],
                "user_name"=>$account_chk['user_name'],
                "si_text"=>$account_chk['si_text'],
                "point"=>$account_chk['point'],
                                ];
        return $account_chk_arr;
        }
      
    }


    private function img_upload(){
        $id = $_POST['id'];
        $sample_data = $_POST['files'];
        $img = $_POST['files'];
        $file_type = $_POST['file_type'];
        $img = str_replace('data:'.$file_type.';base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);

        $date = date('Y-m-d H:i:s');
        $folder_name=$date;
        $file_name=$date.'_'.str_random(16);

        $result=Storage::disk('s3')->directories('public/UserIcons');

        $dir_flg=0;
        foreach($result as $val){
            $cnt_img = count(Storage::disk('s3')->allFiles($val));
            if($cnt_img<30){
                $dir=$val;
                $dir_flg=1;
            }
        }
        if($dir_flg==1){
                Storage::disk('s3')->put($dir.'/'.$file_name.'.png', $fileData);
            }else{
                Storage::disk('s3')->makeDirectory('public/UserIcons/'.$folder_name);
                Storage::disk('s3')->put($folder_name.'/'.$file_name.'.png', $fileData);
            }
        //*アイコン画像をDBに保存
            $user_id= session()->get('user_id');
            $truth_id = User::where('user_id',$user_id)->value('id');
            if($truth_id != $id)exit;
            $change_icons = User::where('id', $id)->first();

            $change_icons->icon_name = $file_name;
        if($dir_flg==1){
            $change_icons->icon_path = str_replace('public/UserIcons/', '', $dir);
        }else{
            $change_icons->icon_path = $folder_name;
        };
        $change_icons->save();

    }












    public function user_info_change(){
        if(!isset($_POST['is_judge_which']))exit;
        if($_POST['is_judge_which'] == 0){//プロフィール変更
            $user_name = $_POST['user_name'];
            $si_text = $_POST['si_text'];
            $id = $_POST['id'];
            $user_id= session()->get('user_id');
            $truth_id = User::where('user_id',$user_id)->value('id');
            if($truth_id != $id)exit;//本人じゃなかったら断つ
            $change_profile = User::where('id', $id)->first();
            $change_profile->user_name = $user_name;
            $change_profile->si_text =$si_text;
            $change_profile->save();
          return $this->account_chk_data();
        }else if($_POST['is_judge_which'] == 1){//pw変更
            $old_pass = $_POST['old_pass'];
            $new_pass = $_POST['new_pass'];
            $id = $_POST['id'];
            $user_id= session()->get('user_id');
            $truth_id = User::where('user_id',$user_id)->value('id');
            if($truth_id != $id)exit;
            $get_pass = User::where('id',$truth_id)->value('user_pw');
            $truth_pass = session()->get('user_pw');
            if($truth_pass != $get_pass)exit;

            if($old_pass == $truth_pass){
                $change_pass = User::where('id', $truth_id)->first();
                $change_pass->user_pw = $new_pass;
                $change_pass->save();
                return 'success';
            }else{
                return 'wrong_pass';
            }
          
        }else if($_POST['is_judge_which'] == 2){
            $img_post = $_POST['img_post'];
            if(session()->has('img_token')){
                $session_img = session()->get('img_token');
                if($img_post!=$session_img){
                    $this->img_upload();
                    session()->put(['img_token'=>$img_post]);
                    }
                }else{
                $this->img_upload();
                session()->put(['img_token'=>$img_post]);
                }




        }
        
  
    }


/* ====================================================================
使い回しメソッド
======================================================================*/
    //*Userモデルでオブジェクトを配列に変換させる
    public function utf_chg($uni_arr){
        $utf8_arr = array();
        $utf8_arr = User::de($uni_arr);
        return $utf8_arr;
    }
    //*メール送信
    public function send_mail(){
        try{ 
/*
TODO:仮登録のメール設定
メールへの接続
*/
//         mb_language("Ja");
//         mb_internal_encoding("UTF-8");
// $mailto = "@gmail.com";
// $subject = "PHPでのメール送信について";
// $content = "こんにちは。";
// $mailfrom="From:" .mb_encode_mimeheader("サンプル") ."<@gmail.com>";
// mb_send_mail($mailto, $subject, $content, $mailfrom);

        }catch(Exception $e){

        }

    }
    
}
