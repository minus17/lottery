<?php
class Loader
{
    /* 路径映射 */
    public static $vendorMap = array(
        'Lottery' => './src',
    );

    /**
     * 自动加载器
     */
    public static function autoload($class)
    {
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }

    /**
     * 解析文件路径
     */
    private static function findFile($class)
    {
        $vendor = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor]; // 文件基目录
        $filePath = substr($class, strlen($vendor)) . '.php'; // 文件相对路径
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路径
    }

    /**
     * 引入文件
     */
    private static function includeFile($file)
    {
        if (is_file($file)) {
            include $file;
        }
    }
}
spl_autoload_register('Loader::autoload'); // 注册自动加载

//双色球
//单式
//$res = Lottery\ShuangseqiuWinning::winning([['01','02','03','04','05','06'],['07']], [['03','04','05','06','07','08'],['07']], 'single');
//复式
//$res = Lottery\ShuangseqiuWinning::winning([['01','02','03','04','05','06'],['07']], [['03','04','05','06','07','08','09'],['07','15']], 'multiple');
//胆拖
//$res = Lottery\ShuangseqiuWinning::winning([['01','02','03','04','05','06'],['07']], [['01','03','08','09'],['02','04','10','18'],['07','16']], 'reqOpt');

//七星彩
//单式
//$res = Lottery\QixingcaiWinning::winning([1,2,3,4,5,6,7],[[1],[2],[0],[7],[1],[6],[7]], 'single');
//复式
//$res = Lottery\QixingcaiWinning::winning([1,2,3,4,5,6,7],[[1,2],[2,4],[3,0],[7,8,9],[1],[8],[0]], 'multiple');

//福彩3D
//单选单式
//$res = Lottery\Fucai3DWinning::winning([1,2,3],[1,2,3], 'single');
//$res = Lottery\Fucai3DWinning::winning([5,2,3],[2,3,5], 'singleMulti');
//$res = Lottery\Fucai3DWinning::winning([1,2,2],[1,2,3], 'doubleMulti');
//$res = Lottery\Fucai3DWinning::winning([2,2,2],[1,2,3,4,5], 'fullMulti');
//$res = Lottery\Fucai3DWinning::winning([3,2,2],[3,2], 'group3Single');
//$res = Lottery\Fucai3DWinning::winning([4,5,4],[1,2,4,5], 'group3Multi');
//$res = Lottery\Fucai3DWinning::winning([2,3,1],[1,2,3], 'group6Single');
//$res = Lottery\Fucai3DWinning::winning([2,3,1],[1,2,3,4,5], 'group6Multi');

var_dump($res);