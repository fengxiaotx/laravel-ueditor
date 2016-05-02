<?php
/**
 * Created by Bane.Shi.
 * Copyright MoenSun
 * User: Bane.Shi
 * Date: 16/5/2
 * Time: 21:20
 */

namespace MoenSun\Ueditor\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use MoenSun\Ueditor\Uploader\Action;

class Controller extends BaseController
{
    public function ueditor(Request $request){
        $CONFIG = config("msueditor");
        $action = $_GET['action'];

        switch ($action) {
            case 'config':
                $result =  json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = Action::actionUpload($CONFIG);
                break;

            /* 列出图片 */
            case 'listimage':
                $result = Action::actionList($CONFIG);
                break;
            /* 列出文件 */
            case 'listfile':
                $result = Action::actionList($CONFIG);
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = Action::actionCrawler($CONFIG);
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state'=> 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }


    }
}