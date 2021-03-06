<?php
class scheduleAdminController extends schedule
{
	function init()
	{
	}

	function procScheduleAdminInsertMid()
	{
		$oModuleModel = getModel('module');
		$oModuleController = getController('module');

		$args = Context::getRequestVars();
		$args->module = 'schedule';
		if($args->module_srl)
		{
			$module_info = $oModuleModel->getModuleInfoByModuleSrl($args->module_srl);
			if($module_info->module_srl != $args->module_srl)
			{
				unset($args->module_srl);
			}
		}
		if($args->module_srl)
		{
			$output = $oModuleController->updateModule($args);
			$msg_code = 'success_updated';
		}
		else
		{
			$output = $oModuleController->insertModule($args);
			$msg_code = 'success_registed';
		}

		if(!$output->toBool())
		{
			return $output;
		}

		$this->setMessage($msg_code);

		if(!in_array(Context::getRequestMethod(), array('XMLRPC', 'JSON')))
		{
			$redirectUrl = Context::get('success_return_url') ? Context::get('success_return_url') : getNotEncodedUrl('', 'module', 'admin', 'act', 'dispScheduleAdminInsertModule', 'module_srl', $module_srl);
			$this->setRedirectUrl($redirectUrl);
		}
	}

	function procScheduleAdminInsertConfig()
	{
		$oModuleController = getController('module');
		$config->viewconfig = Context::get('viewconfig');

		$this->setMessage('success_updated');

		$oModuleController->updateModuleConfig('schedule', $config);

		if(!in_array(Context::getRequestMethod(),array('XMLRPC','JSON')))
		{
			$returnUrl = Context::get('success_return_url') ? Context::get('success_return_url') : getNotEncodedUrl('', 'module', 'admin', 'act', 'dispScheduleAdminConfig');
			header('location: ' . $returnUrl);
			return;
		}
	}
}
/* End of file */
