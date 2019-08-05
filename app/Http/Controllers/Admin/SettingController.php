<?php

namespace App\Http\Controllers\Admin;

use App\Common\Constant;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //Start Controller Banner
    public function bannerList(){
        $banners = $this->settingService->getBannerAll();
        return $this->viewAdmin('setting.banner_slider',[
            'banners' => $banners
        ]);
    }

    public function bannerCreate(Request $request){
        $this->settingService->createBanner($request);
        return redirect()->route('admin.setting.banner');
    }

    public function bannerUpdate(Request $request){
        $this->settingService->updateBanner($request);
        return redirect()->route('admin.setting.banner');
    }

    public function bannerDestroy($id){
        $this->settingService->deleteBanner($id);
        return redirect()->route('admin.setting.banner');
    }
    //End Controller Banner

    //Start Controller Top Banner
    public function topBannerList(){
        $banners = $this->settingService->getTopBannerAll();
        return $this->viewAdmin('setting.top_banner',[
            'banners' => $banners
        ]);
    }

    public function topBannerCreate(Request $request){
        $this->settingService->createTopBanner($request);
        return redirect()->route('admin.setting.topBanner');
    }

    public function topBannerDestroy($id){
        $this->settingService->deleteTopBanner($id);
        return redirect()->route('admin.setting.topBanner');
    }
    //End Controller Top Banner

    //Start Controller Tag Key
    public function tagList(){
        $tagOneList = $this->settingService->getTagByTagType(Constant::$TAG_KEY_ONE);
        $tagTwoList = $this->settingService->getTagByTagType(Constant::$TAG_KEY_TWO);
        return $this->viewAdmin('setting.tag',[
            'tagOneList' => $tagOneList,
            'tagTwoList' => $tagTwoList
        ]);
    }

    public function tagCreate(Request $request){
        $this->settingService->createTag($request);
        return redirect()->route('admin.setting.tag');
    }

    public function tagDestroy($id){
        $this->settingService->deleteTag($id);
        return redirect()->route('admin.setting.tag');
    }
    //End Controller Tag Key

    //Start Controller App Info
    public function appInfo(){
        $appInfo = $this->settingService->getAppInfo();
        return $this->viewAdmin('setting.app_info',['appInfo' => $appInfo]);
    }

    public function updateAppInfo(Request $request){
        $this->settingService->updateAppInfo($request);
        return redirect()->route('admin.setting.app');
    }
    //End Controller App Info

    public function appAboutUpdate(){
        $appInfo = $this->settingService->getAppInfo();
        return $this->viewAdmin('setting.app_about',['appInfo' => $appInfo]);
    }

    public function updateAboutAppInfo(Request $request){
        $aboutContent = $request->about_content;
        if(isset($aboutContent)){
            $this->settingService->updateAppAboutContent($aboutContent);
        }
        return redirect()->route('admin.setting.app_about.show');
    }

    //Out source
    public function appOutSourceUpdate(){
        $appInfo = $this->settingService->getAppInfo();
        return $this->viewAdmin('setting.out_source_info',['appInfo' => $appInfo]);
    }

    public function updateOutSourceAppInfo(Request $request){
        $outSourceContent = $request->out_source_content;
        if(isset($outSourceContent)){
            $this->settingService->updateAppOutSourceContent($outSourceContent);
        }
        return redirect()->route('admin.setting.app_out_source.show');
    }
}
