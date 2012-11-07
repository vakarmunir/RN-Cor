<?php

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.helper');

// Load the base adapter.
require_once JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer/adapter.php';


class plg##Plugtype####Plugin## extends FinderIndexerAdapter
{
	
	/**
	* The plugin identifier.
	*
	* @var    string
	* @since  2.5
	*/
	protected $context = '##Plugin##';
	
	/**
	 * The extension name.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $extension = 'com_##plugin##';
	
	/**
	 * The sublayout to use when rendering the results.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $layout = '##plugin##';
	
	/**
	 * The type of content that the adapter indexes.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $type_title = '##Plugin##';
	
	/**
	 * The table name.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $table = '#__##plugin##';
	
	/**
	 * The field the published state is stored in.
	 *
	 * @var    string
	 * @since  2.5
	 */
	protected $state_field = 'published';	
	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onFinderCategoryChangeState($extension, $pks, $value)
	{
		// Make sure we're handling com_contact categories
		if ($extension == 'com_##plugin##')
		{
			$this->categoryStateChange($pks, $value);
		}
	}
	
	/**
	* Method to remove the link information for items that have been deleted.
	*
	* This event will fire when contacts are deleted and when an indexed item is deleted.
	*
	* @param   string  $context  The context of the action being performed.
	* @param   JTable  $table    A JTable object containing the record to be deleted
	*
	* @return  boolean  True on success.
	*
	* @since   2.5
	* @throws  Exception on database error.
	*/
	public function onFinderAfterDelete($context, $table)
	{
		if ($context == 'com_##plugin##.item')
		{
			$id = $table->id;
		}
		elseif ($context == 'com_finder.index')
		{
			$id = $table->link_id;
		}
		else
		{
			return true;
		}
		// Remove the items.
		return $this->remove($id);
	}
	
	/**
	 * Method to determine if the access level of an item changed.
	 *
	 * @param   string   $context  The context of the content passed to the plugin.
	 * @param   JTable   $row      A JTable object
	 * @param   boolean  $isNew    If the content has just been created
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.5
	 * @throws  Exception on database error.
	 */
	public function onFinderAfterSave($context, $row, $isNew)
	{
		// We only want to handle contacts here
		if ($context == 'com_##plugin##.item')
		{
			
			// Reindex the item
			$this->reindex($row->id);
		}

	
		return true;
	}
	
	/**
	 * Method to reindex the link information for an item that has been saved.
	 * This event is fired before the data is actually saved so we are going
	 * to queue the item to be indexed later.
	 *
	 * @param   string   $context  The context of the content passed to the plugin.
	 * @param   JTable   $row      A JTable object
	 * @param   boolean  $isNew    If the content is just about to be created
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.5
	 * @throws  Exception on database error.
	 */
	public function onFinderBeforeSave($context, $row, $isNew)
	{
		// We only want to handle contacts here
		if ($context == 'com_##plugin##.item')
		{
			// Query the database for the old access level if the item isn't new
			if (!$isNew)
			{
				$this->checkItemAccess($row);
			}
		}

	
		return true;
	}
	
	/**
	 * Method to update the link information for items that have been changed
	 * from outside the edit screen. This is fired when the item is published,
	 * unpublished, archived, or unarchived from the list view.
	 *
	 * @param   string   $context  The context for the content passed to the plugin.
	 * @param   array    $pks      A list of primary key ids of the content that has changed state.
	 * @param   integer  $value    The value of the state that the content has been changed to.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function onFinderChangeState($context, $pks, $value)
	{
		// We only want to handle contacts here
		if ($context == 'com_##plugin##.item')
		{
			$this->itemStateChange($pks, $value);
		}
	
		// Handle when the plugin is disabled
		if ($context == 'com_plugins.plugin' && $value === 0)
		{
			$this->pluginDisable($pks);
		}
	}
	
	/**
	 * Method to index an item. The item must be a FinderIndexerResult object.
	 *
	 * @param   FinderIndexerResult  $item    The item to index as an FinderIndexerResult object.
	 * @param   string               $format  The item format
	 *
	 * @return  void
	 *
	 * @since   2.5
	 * @throws  Exception on database error.
	 */
	protected function index(FinderIndexerResult $item, $format = 'html')
	{
		// Check if the extension is enabled
		if (JComponentHelper::isEnabled($this->extension) == false)
		{
			return;
		}
	
		// Initialize the item parameters.
		$registry = new JRegistry;
		$registry->loadString($item->params);
		$item->params = $registry;
	
		// Build the necessary route and path information.
		$item->url = $this->getURL($item->id, $this->extension, $this->layout);
		$item->route = ##Plugin##HelperRoute::get##Plugin##Route($item->slug, $item->catslug);
		$item->path = FinderIndexerHelper::getContentPath($item->route);
	
		// Get the menu title if it exists.
		$title = $this->getItemMenuTitle($item->url);
	
		// Adjust the title if necessary.
		if (!empty($title) && $this->params->get('use_menu_title', true))
		{
			$item->title = $title;
		}
	
		// Do something more
		
		// Get content extras.
		FinderIndexerHelper::getContentExtras($item);
	
		// Index the item.
		FinderIndexer::index($item);
	}
	
	/**
	 * Method to setup the indexer to be run.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   2.5
	 */
	protected function setup()
	{
		// Load dependent classes.
		require_once JPATH_SITE . '/components/com_##plugin##/helpers/route.php';
	
		// This is a hack to get around the lack of a route helper.
		FinderIndexerHelper::getContentPath('index.php?option=com_##plugin##');
	
		return true;
	}
	
	/**
	 * Method to get the SQL query used to retrieve the list of content items.
	 *
	 * @param   mixed  $sql  A JDatabaseQuery object or null.
	 *
	 * @return  JDatabaseQuery  A database object.
	 *
	 * @since   2.5
	 */
	protected function getListQuery($sql = null)
	{
		$db = JFactory::getDbo();
		// Check if we can use the supplied SQL query.
		$sql = is_a($sql, 'JDatabaseQuery') ? $sql : $db->getQuery(true);	
		$sql->select('*');
		$sql->from('#__##plugin AS a');
		return $sql;
	}	
}
