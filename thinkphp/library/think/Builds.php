<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

use function foo\func;

class Builds
{
    /**
     * 根据传入的build资料创建目录和文件
     * @access protected
     * @param  array  $build build列表
     * @param  string $namespace 应用类库命名空间
     * @param  bool   $suffix 类库后缀
     * @param  string $style　模板样式选择
     * @return void
     */
    public static function run(array $build = [], $namespace = 'app', $suffix = false,$style,$fields)
    {
        // 锁定
        $lockfile = APP_PATH . 'build.lock';
        if (is_writable($lockfile)) {
            return;
        } elseif (!touch($lockfile)) {
            throw new Exception('应用目录[' . APP_PATH . ']不可写，目录无法自动生成！<BR>请手动生成项目目录~', 10006);
        }
        foreach ($build as $module => $list) {

            if ('__dir__' == $module) {
                // 创建目录列表
                self::buildDir($list);
            } elseif ('__file__' == $module) {
                // 创建文件列表
                self::buildFile($list);
            } else {
                // 创建模块

                self::module($module, $list, $namespace, $suffix,$style,$fields);

            }
        }
        // 解除锁定
        unlink($lockfile);
    }

    /**
     * 创建目录
     * @access protected
     * @param  array $list 目录列表
     * @return void
     */
    protected static function buildDir($list)
    {
        foreach ($list as $dir) {
            if (!is_dir(APP_PATH . $dir)) {
                // 创建目录
                mkdir(APP_PATH . $dir, 0755, true);
            }
        }
    }

    /**
     * 创建文件
     * @access protected
     * @param  array $list 文件列表
     * @return void
     */
    protected static function buildFile($list)
    {
        foreach ($list as $file) {
            if (!is_dir(APP_PATH . dirname($file))) {
                // 创建目录
                mkdir(APP_PATH . dirname($file), 0755, true);
            }
            if (!is_file(APP_PATH . $file)) {
                file_put_contents(APP_PATH . $file, 'php' == pathinfo($file, PATHINFO_EXTENSION) ? "<?php\n" : '');
            }
        }
    }

    /**
     * 创建模块
     * @access public
     * @param  string $module 模块名
     * @param  array  $list build列表
     * @param  string $namespace 应用类库命名空间
     * @param  bool   $suffix 类库后缀
     * @return void
     */
    public static function module($module = '', $list = [], $namespace = 'app', $suffix = false,$style,$fields)
    {
        $module = $module ? $module : '';
//        var_dump($module);
        if (!is_dir(APP_PATH . $module)) {
            // 创建模块目录
            mkdir(APP_PATH . $module);
        }

        if (basename(RUNTIME_PATH) != $module) {

            // 创建配置文件和公共文件
            self::buildCommon($module);
            // 创建模块的默认页面
//            $indexs = $list['controller'];
//            $index = implode($indexs);
//            self::buildHello($module, $namespace, $suffix,$index);

        }
        if (empty($list)) {
            // 创建默认的模块目录和文件
            $list = [
                '__file__' => ['config.php', 'common.php'],
                '__dir__'  => ['controller', 'model', 'view'],
            ];
        }
        if(!empty($list)) {
            !empty($list['model']) ? $table_name =  $list['model'][0] : $table_name = '';
        }
        // 创建子目录和文件
        foreach ($list as $path => $file) {
            $modulePath = APP_PATH . $module . DS;

            if ('__dir__' == $path) {
                // 生成子目录
                foreach ($file as $dir) {
                    if (!is_dir($modulePath . $dir)) {
                        // 创建目录
                        mkdir($modulePath . $dir, 0755, true);
                    }
                }
            } elseif ('__file__' == $path) {
                // 生成（空白）文件
                foreach ($file as $name) {
                    if (!is_file($modulePath . $name)) {
                        file_put_contents($modulePath . $name, 'php' == pathinfo($name, PATHINFO_EXTENSION) ? "<?php\n" : '');
                    }
                }
            } else {
//                var_dump($path);
                // 生成相关MVC文件
                // 全部小写
                $module = strtolower($module);
                // 首字母大写
                $modules = ucfirst($module);
                foreach ($file as $val) {
                    $val      = trim($val);
                    $filename = $modulePath . $path . DS . $val . ($suffix ? ucfirst($path) : '') . EXT;
                    $space    = $namespace . '\\' . ($module ? $module . '\\' : '') . $path;
                    $class    = $val . ($suffix ? ucfirst($path) : '');
                    // 全部小写
                    $names = strtolower($val);
                    $base = substr($val,-4);
//                    var_dump($class);
//                    var_dump($names);
                    switch ($path) {
                        case 'controller': // 控制器
                            if($base == 'Base'){
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style . DS . 'default_controller_Base.tpl');
                                $content=str_replace(['{$module}','{$modules}'],[$module,$modules],$content);
                            }else {
//                            $content = "<?php\nnamespace {$space};\n\nclass {$class}\n{\n\n}";
                                // 获取组装好的表名 比如land_post = LandPost
                                !empty($table_name) ? $tb_name = $table_name : $tb_name = $val ;
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style . DS . 'default_controller.tpl');
                                $content = str_replace(['{$space}', '{$class}', '{$name}', '{$names}','{$modules}','{$module}','{$tb_name}'], [$space, $class, $val, $names,$modules,$module,$tb_name], $content);
                            }
                            break;
                        case 'model': // 模型
                            if($base == 'Base')
                            {
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_model_Base.tpl');
                                $content=str_replace(['{$module}','{$modules}'],[$module,$modules],$content);
                            }else {
//                            $content = "<?php\nnamespace {$space};\n\nuse think\Model;\n\nclass {$class} extends Model\n{\n\n}";
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_model.tpl');
                                $content = str_replace(['{$space}', '{$class}', '{$name}','{$modules}','{$module}'], [$space, $class, $val,$modules,$module], $content);
                            }
                            break;
                        case 'view': // 视图
//                            var_dump(substr($names,0,strrpos($names,SYS_DS_PROS)));
                            $nams = substr($names,0,strrpos($names,SYS_DS_PROS));
                            $filename = $modulePath . $path . DS . $names . '.html';
                            if (!is_dir(dirname($filename))) {
                                // 创建目录
                                mkdir(dirname($filename), 0755, true);
                            }
                            $vals = substr($val,-4);
                            if($vals =='list')
                            {
                                $content=file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_view_list.tpl');
                                $content = str_replace(['{$name}'], [$nams], $content);
                            }else if($vals=='edit')
                            {
                                $content=file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_view_edit.tpl');

                            }else{
                                $content='';
                            }
                            break;
                        case 'logic':
                            // 模型
                            if($base == 'Base'){
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_logic_Base.tpl');
                                $content=str_replace(['{$module}','{$modules}'],[$module,$modules],$content);
                            }else {
                                //                            $content = "<?php\nnamespace {$space};\n\nuse think\Model;\n\nclass {$class} extends Model\n{\n\n}";
                                // 获取组装好的表名 比如land_post = LandPost
                                !empty($table_name) ? $tb_name = $table_name : $tb_name = $val ;
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_logic.tpl');
                                $content = str_replace(['{$space}', '{$class}', '{$name}', '{$names}','{$modules}','{$module}','{$fields}','{$tb_name}'], [$space, $class, $val, $names,$modules,$module,$fields,$tb_name], $content);
                            }
                            break;
                        case 'validate':
                            // 模型
                            if($base == 'Base')
                            {
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_validate_Base.tpl');
                                $content=str_replace(['{$module}','{$modules}'],[$module,$modules],$content);
                            }else{
                                //                            $content = "<?php\nnamespace {$space};\n\nuse think\Model;\n\nclass {$class} extends Model\n{\n\n}";
                            $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_validate.tpl');
                            $content = str_replace(['{$space}', '{$class}','{$name}','{$modules}','{$module}'], [$space, $class,$val,$modules,$module], $content);
                            }
                            break;
                        case 'error':
                            if($base == 'Base')
                            {
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_error_Base.tpl');
                                $content=str_replace(['{$space}', '{$class}', '{$name}','{$modules}','{$module}'], [$space, $class, $val,$modules,$module], $content);
                            }elseif($val == 'Common'){
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_error_Common.tpl');
                                $content=str_replace(['{$space}', '{$class}', '{$name}','{$modules}','{$module}'], [$space, $class, $val,$modules,$module], $content);
                            }else{
                                //                            $content = "<?php\nnamespace {$space};\n\nuse think\Model;\n\nclass {$class} extends Model\n{\n\n}";
                                $content = file_get_contents(APP_PATH .DS.'common'.DS.'tpl'.DS.$style. DS . 'default_error.tpl');
                                $content = str_replace(['{$space}', '{$class}','{$name}','{$modules}','{$module}'], [$space, $class,$val,$modules,$module], $content);
                            }
                            break;
                        default:
                            // 其他文件
                            $content = "<?php\nnamespace {$space};\n\nclass {$class}\n{\n\n}";

                    }

                    if (!is_file($filename)) {
                        file_put_contents($filename, $content);
                    }
                }
            }
        }

    }

    /**
     * 创建模块的欢迎页面
     * @access public
     * @param  string $module 模块名
     * @param  string $namespace 应用类库命名空间
     * @param  bool   $suffix 类库后缀
     * @return void
     */
    protected static function buildHello($module, $namespace, $suffix = false,$index='Index')
    {
//    var_dump($index);

        $filename = APP_PATH . ($module ? $module . DS : '') . 'controller' . DS . $index . ($suffix ? 'Controller' : '') . EXT;
        var_dump($filename);

        if (!is_file($filename)) {
            $content = file_get_contents(THINK_PATH . 'tpl' . DS . 'default_controller.tpl');
            $content = str_replace(['{$app}', '{$module}', '{layer}', '{$suffix}'], [$namespace, $module ? $module . '\\' : '', 'controller', $suffix ? 'Controller' : ''], $content);

            if (!is_dir(dirname($filename))) {
                mkdir(dirname($filename), 0755, true);
            }
            file_put_contents($filename, $content);
        }

    }

    /**
     * 创建模块的公共文件
     * @access public
     * @param  string $module 模块名
     * @return void
     */
    protected static function buildCommon($module)
    {
        $filename = CONF_PATH . ($module ? $module . DS : '') . 'config.php';
        if (!is_file($filename)) {
            file_put_contents($filename, "<?php\n//配置文件\nreturn [\n\n];");
        }
        $filename = APP_PATH . ($module ? $module . DS : '') . 'common.php';
        if (!is_file($filename)) {
            file_put_contents($filename, "<?php\n");
        }
    }
}
