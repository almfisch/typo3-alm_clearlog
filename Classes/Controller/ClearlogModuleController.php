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

        $table = $this->clearTablesArray[0];
        $query = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable($table);
        $result = $query->fetchAll('SHOW TABLE STATUS');


        foreach($result as $row)
        {
        	if(in_array($row['Name'], $this->clearTablesArray))
			{
    			$tableSize = ($row['Data_length'] + $row['Index_length']) / 1024;
    			$tableInfo[$row['Name']]['size'] = sprintf("%.2f", $tableSize);
    		}
        }
        foreach($this->clearTablesArray as $table)
    	{
    		$query = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable($table);
            $query->count('*');
            $query->from($table);
            $result = $query->execute()->fetchColumn(0);
    		$tableInfo[$table]['rows'] = $result;
    	}

		$this->view->assign('tableInfo', $tableInfo);
    }


	/**
     * ClearTable Action
     *
     * @param string $tableName
     * @return void
     */
    protected function clearTableAction($tableName)
    {
		if($tableName == 'sys_file_processedfile')
		{
			$processedFileRep = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ProcessedFileRepository::class);
        	$processedFileRep->removeAll();
		}

		$query = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable($tableName);
		$query->truncate($tableName);

    	$this->redirect('index');
    }


    /**
     * ClearAll Action
     *
     * @return void
     */
    protected function clearAllAction()
    {
    	foreach($this->clearTablesArray as $table)
    	{
    		if($table == 'sys_file_processedfile')
		    {
                $processedFileRep = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\ProcessedFileRepository::class);
                $processedFileRep->removeAll();
            }

    		$query = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getConnectionForTable($table);
    		$query->truncate($table);
    	}

    	$this->redirect('index');
    }
}
