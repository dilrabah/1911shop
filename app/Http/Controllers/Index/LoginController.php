<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\Mail\sendCode;
use Illuminate\Support\Facades\Mail;
use App\Member;

class LoginController extends Controller
{
	//登录
    public function login(){
    	return view('index.log');
    }

    //注册
    public function reg(){
    	return view('index.reg');
    }

    //发送短信
    public function sendSms(){
    	$tel = request() ->username;
    	$reg = '/^1[3|4|5|6|7|8|9]\d{9}$/';
    	if(!preg_match($reg,$tel)){
    		echo json_encode(['code'=>'2','msg'=>'请输入正确手机号']);die;
    	}

    	$code = rand(100000,999999);
    	//发送验证码
    	$res = $this ->sms($tel,$code);
    	if($res['Message']=='OK'){
    		session(['code'=>['name'=>$tel,'code'=>$code]]);
            request()->session()->save();
    		echo json_encode(['code'=>'1','msg'=>'发送成功，请注意接收']);die;
    	}

    }

    //发送短信
    public function sms($tel,$code){
    	AlibabaCloud::accessKeyClient('LTAI4G1AdUdxCAU1UMgMQQWg', 'Q7bNe67mZfMODMq8PSTPRwc4uU7lkV')
                        ->regionId('cn-hangzhou')
                        ->asDefaultClient();

		try {
		    $result = AlibabaCloud::rpc()
		                          ->product('Dysmsapi')
		                          // ->scheme('https') // https | http
		                          ->version('2017-05-25')
		                          ->action('SendSms')
		                          ->method('POST')
		                          ->host('dysmsapi.aliyuncs.com')
		                          ->options([
		                                        'query' => [
		                                          'RegionId' => "cn-hangzhou",
		                                          'PhoneNumbers' => $tel,
		                                          'SignName' => "晋菲小巷",
		                                          'TemplateCode' => "SMS_185230583",
		                                          'TemplateParam' => "{code:$code}",
		                                        ],
		                                    ])
		                          ->request();
		    return $result->toArray();
		} catch (ClientException $e) {
		    return $e->getErrorMessage() . PHP_EOL;
		} catch (ServerException $e) {
		    return $e->getErrorMessage() . PHP_EOL;
		}
    }

    //发送邮箱
    public function sendEmail(){
    	$email = request() ->username;
    	$reg = '/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/';
    	if(!preg_match($reg,$email)){
    		echo json_encode(['code'=>'2','msg'=>'请输入正确邮箱']);die;
    	}
    	$code = rand(100000,999999);
    	//使用邮箱发送验证码
    	Mail::to($email)->send(new sendCode($code));
        session(['code'=>['name'=>$email,'code'=>$code]]);
        request()->session()->save();
        echo json_encode(['code'=>'1','msg'=>'发送成功，请注意接收']);die;
    }

    //注册
    public function regdo(Request $request){
        $post = $request ->except('_token');
        $code = $request ->session() ->get('code');
        //判断验证码是否一致
        if($post['username']!=$code['name'] || $post['code']!=$code['code']){
            return redirect('/reg') ->with('msg','您的验证码错误');
        }
        //判断密码是否一致
        if($post['pwd']!==$post['repwd']){
            return redirect('/reg') ->with('msg','您的两次密码不一致');
        }

        //入库
        $reg = '/^1[3|4|5|6|7|8|9]\d{9}$/';
        if(preg_match($reg,$post['username'])){
            $post['tel'] = $post['username'];
        }
        $reg = '/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/';
        if(preg_match($reg,$post['username'])){
            $post['email'] = $post['username'];
        }

        unset($post['username']);
        unset($post['repwd']);
        unset($post['code']);
        $post['pwd'] = encrypt($post['pwd']);

        $res = Member::insert($post);
        if($res){
            return redirect('login');
        }

    }

    //登录
    public function loginDo(){
        $post = request() ->except('_token');
        //dd($post);
        //入库
        $where = [];
        $reg = '/^1[3|4|5|6|7|8|9]\d{9}$/';
        if(preg_match($reg,$post['username'])){
            $where['tel'] = $post['username'];
        }
        $reg = '/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/';
        if(preg_match($reg,$post['username'])){
            $where['email'] = $post['username'];
        }

        //查询用户
        $user = Member::where($where) ->first();
        if(decrypt($user->pwd)!=$post['pwd']){
            return redirect('/login')->with('msg','用户名或密码不正确');
        }

        session(['user'=>$user]);
        //有回调地址跳回回调地址
        if($post['refer']){
            return redirect($post['refer']);
        }
        return redirect('/');

    }



}
