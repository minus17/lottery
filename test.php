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

//大乐透
//单式
//$res = Lottery\LotteryHelper::win(111, [['03','09','15','18','26'],['06','12']],[['04','09','17','18','27'],['06','12']]);
//复式
//$res = Lottery\LotteryHelper::win(112, [['03','09','15','18','26'],['06','12']],[['04','09','17','18','27','33'],['06','11','12']]);
//胆拖
//$res = Lottery\LotteryHelper::win(113, [['03','09','15','18','26'],['06','12']],[['04','09','27','33'],['17','18','19'],['06'],['11','12']]);


//七星彩
//单式
//$res = Lottery\LotteryHelper::win(121, [1,2,3,4,5,6,7],[1,2,0,7,1,6,7]);
//复式
//$res = Lottery\LotteryHelper::win(122, [1,2,3,4,5,6,7],[[1,2],[2,4],[3,0],[7,8,9],[1],[8],[0]]);

//排列3
//直选单式
//$res = Lottery\LotteryHelper::win(121, [1,2,3,4,5,6,7],[1,2,0,7,1,6,7]);3
//直选复式
//$res = Lottery\LotteryHelper::win(121, [1,2,3],[[1],[2,3],[3,4]]);

//双色球
//单式
//$res = Lottery\LotteryHelper::win(211, [['01','02','03','04','05','06'],['07']], [['03','04','05','06','07','08'],['07']]);
//复式
//$res = Lottery\LotteryHelper::win(212, [['01','02','03','04','05','06'],['07']], [['03','04','05','06','07','08','09'],['07','15']]);
//胆拖
//$res = Lottery\LotteryHelper::win(213, [['01','02','03','04','05','06'],['07']], [['01','03','08','09'],['02','04','10','18'],['07','16']]);

//福彩3D
//单选单式
//$res = Lottery\LotteryHelper::win(221, [1,2,3],[1,2,3]);
//$res = Lottery\LotteryHelper::win(222, [5,2,3],[2,3,5]);
//$res = Lottery\LotteryHelper::win(223, [1,2,2],[1,2,3]);
//$res = Lottery\LotteryHelper::win(224, [2,2,2],[1,2,3,4,5]);
//$res = Lottery\LotteryHelper::win(225, [3,2,2],[3,2]);
//$res = Lottery\LotteryHelper::win(226, [4,5,4],[1,2,4,5]);
//$res = Lottery\LotteryHelper::win(227, [2,3,1],[1,2,3]);
//$res = Lottery\LotteryHelper::win(228, [2,3,1],[1,2,3,4,5]);

var_dump($res);