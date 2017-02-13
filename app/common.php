
<?php

	class common{





		/*
		 * 渲染页面
		 * 
		 * @author liubin
		 * @date 2016-02-10
		 *
		*/
		protected function render($view='',$data=[]){

			$viewpath 	= SEC_ROOT_PATH .'/view/';
			$viewfile 	= $viewpath . ($view ? $view : CONTROLLER . '/' .ACTION ) .'.php';
			if(is_file($viewfile)){
		        // 页面缓存
				ob_start();
				ob_implicit_flush(0);
				// 模板阵列变量分解成为独立变量
				extract($data, EXTR_OVERWRITE);
				include $viewfile;
				// 获取并清空缓存
				$content = ob_get_clean();
				echo $content;
			}else{
				throw new Exception("模板文件不存在");
			}
		}




		/*
		 * ajax 返回
		 *
		*/
		protected function ajaxreturn($data){
			$return = json_encode($data);
			exit($return);
		}





	}

