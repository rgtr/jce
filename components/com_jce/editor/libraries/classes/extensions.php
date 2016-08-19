<?php

/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2016 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('RESTRICTED');
// set as an extension parent
if (!defined('_WF_EXT')) {
    define('_WF_EXT', 1);
}

class WFExtension extends JObject {

    /**
     * Constructor activating the default information of the class
     *
     * @access public
     */
    public function __construct($config = array()) {
        parent::__construct();

        // set extension properties
        $this->setProperties($config);
    }

    /**
     * Returns a reference to a WFExtension object
     *
     * This method must be invoked as:
     *    <pre>  $extension = WFExtension::getInstance();</pre>
     *
     * @access  public
     * @return  object WFExtension
     */
    /* public static function getInstance()
      {
      static $instance;

      if (!is_object($instance)) {
      $instance = new WFExtension();
      }
      return $instance;
      } */

    /**
     * Display the extension
     * @access $public
     */
    public function display() {}

    /**
     * Load a plugin extension
     *
     * @access  public
     * @return 	array
     */
    private static function _load($types = array(), $extension = null, $config = array()) {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $extensions = array();

        if (!isset($config['base_path'])) {
            $config['base_path'] = WF_EDITOR;
        }

        // core extensions path
        $path = $config['base_path'] . '/extensions';

        // cast as array
        $types = (array) $types;

        // get all installed plugins
        $installed = JPluginHelper::getPlugin('jce');

        if (!empty($installed)) {
            foreach ($installed as $p) {

                // check for delimiter, only load "extensions"
                if (strpos($p->name, '-') === false || strpos($p->name, 'editor-') !== false) {
                    continue;
                }

                // set path
                $p->path = JPATH_PLUGINS . '/jce/' . $p->name;
                
                // Joomla 1.5
                if (!defined('JPATH_PLATFORM')) {
                    $p->path = JPATH_PLUGINS . '/jce';
                }

                // get type and name
                $parts = explode("-", $p->name);
                $p->folder    = $parts[0];
                $p->extension = $parts[1];

                // load the correct type if set
                if (!empty($types) && !in_array($p->folder, $types)) {
                    continue;
                }

                // specific extension
                if ($extension && $p->extension !== $extension) {
                    continue;
                }

                // add to array
                $extensions[$p->extension] = $p;
            }
        }

        // get legacy extensions
        $legacy = JFolder::folders(WF_EDITOR . '/extensions', '.', false, true);

        foreach($legacy as $item) {
            $type = basename($item);

            // load the correct type if set
            if (!empty($types) && !in_array($type, $types)) {
                continue;
            }

            // specific extension
            if ($extension && !JFile::exists($item . '/' . $extension . '.php')) {
                continue;
            }

            if (!empty($extension)) {
                // already loaded as Joomla plugin
                if (isset($extensions[$extension])) {
                    continue;
                }

                $files = array($item . '/' . $extension . '.xml');
            } else {
                $files = JFolder::files($item, '\.xml$', false, true);
            }

            foreach($files as $file) {
                $extension = basename($file, '.xml');

                $object = new stdClass();
                $object->folder     = $type;
                $object->path       = dirname($file);
                $object->extension  = $extension;

                if (!isset($extensions[$extension])) {
                    $extensions[$extension] = $object;
                }
            }
        }

        return $extensions;
    }

    /**
     * Load & Call an extension
     *
     * @access  public
     * @param	array $config
     * @return 	mixed
     */
    public static function loadExtensions($type, $extension = null, $config = array()) {
        jimport('joomla.filesystem.folder');
        jimport('joomla.filesystem.file');

        $language = JFactory::getLanguage();

        if (!isset($config['base_path'])) {
            $config['base_path'] = WF_EDITOR;
        }

        // sanitize $type
        $type = preg_replace('#[^A-Z0-9\._-]#i', '', $type);

        // sanitize $extension
        if ($extension) {
            $extension = preg_replace('#[^A-Z0-9\._-]#i', '', $extension);
        }

        // Get all extensions
        $extensions = self::_load((array) $type, $extension, $config);

        $result = array();

        if (!empty($extensions)) {
            foreach ($extensions as $item) {
                $name   = isset($item->extension) ? $item->extension : '';

                $type   = $item->folder;
                $path   = $item->path;

                if ($name) {
                    $root = $path . '/' . basename($path) . '.php';

                    // legacy
                    if (dirname($path) === WF_EDITOR_EXTENSIONS) {
                        $root = $path . '/' . $name . '.php';
                    }

                    if (file_exists($root)) {
                        // Load root extension file
                        require_once($root);

                        // Load Extension language file (legacy)
                        $language->load('com_jce_' . $type . '_' . $name, JPATH_SITE);
                        // Joomla plugins
                        $language->load('plg_jce_' . $type . '_' . $name, JPATH_SITE);

                        // Return array of extension names
                        $result[$type][] = $name;

                        // if we only want a named extension
                        if ($extension && $extension == $name) {
                            return $name;
                        }
                    }
                }
            }
        }

        // only return extension types requested
        if ($type && array_key_exists($type, $result)) {
            return $result[$type];
        }

        // Return array or extension name
        return $result;
    }

    /**
     * Return a parameter for the current plugin / group
     * @param 	object $param Parameter name
     * @param 	object $default Default value
     * @return 	string Parameter value
     */
    public function getParam($param, $default = '') {
        $wf = WFEditor::getInstance();

        return $wf->getParam($param, $default);
    }

    public function getView($options = array()) {
        return new WFView($options);
    }
}

?>
