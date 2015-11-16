<?php
namespace Alm\AlmClearlog\Controller;

class ClearlogModuleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	/**
	 * action initialize
	 *
	 * @return void
	 */
	protected function initializeAction()
	{
		if($this->settings['clearTablesArray'])
		{
			$this->clearTablesArray = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['clearTablesArray']);
		}
		else
		{
			$this->clearTablesArray = array('sys_log','sys_history');
		}
	}


	/**
     * Index Action
     *
     * @return void
     */
    protected function indexAction()
    {
    	$tableInfo = array();

    	$result = $GLOBALS['TYPO3_DB']->sql_query('SHOW TABLE STATUS');
		while($row = mysqli_fetch_array($result))
		{
			if(in_array($row['Name'], $this->clearTablesArray))
			{
    			$tableSize = ($row['Data_length'] + $row['Index_length']) / 1024;
    			$tableInfo[$row['Name']]['size'] = sprintf("%.2f", $tableSize);
    		}
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($result);

		foreach($this->clearTablesArray as $key => $value)
    	{
    		$result = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', $value, '');
			$tableRowCount = $GLOBALS['TYPO3_DB']->sql_num_rows($result);
			$tableInfo[$value]['rows'] = $tableRowCount;
			$GLOBALS['TYPO3_DB']->sql_free_result($result);
    	}

		$this->view->assign('tableInfo', $tableInfo);
    }


    /**
     * Clear Action
     *
     * @return void
     */
    protected function clearAction()
    {
    	foreach($this->clearTablesArray as $key => $value)
    	{
    		$GLOBALS['TYPO3_DB']->sql_query('TRUNCATE TABLE ' . $value);
    	}

    	$this->redirect('index');
    }
}
