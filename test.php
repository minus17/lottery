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
/** 单式如: 01-02-03-04-05-06-16
* 复式如: 01|10-02|12|14-03-04-05-06-15|16
* 胆拖如: 03-04-05,05-06-07-08-09-10,15|16
 */

//$res = Lottery\ShuangseqiuWinning::winning([['01','02','03','04','05','06'],['07']], [['01','03','08','09'],['02','04','10','18'],['07','16']], 'reqOpt');
//$res = Lottery\ShuangseqiuWinning::winning([['01','02','03','04','05','06'],['07']], [['03','04','05','06','07','08'],['07']], 'single');
$res = Lottery\ShuangseqiuWinning::winning([['01','02','03','04','05','06'],['07']], [['03','04','05','06','07','08','09'],['07','15']], 'multiple');
var_dump($res);