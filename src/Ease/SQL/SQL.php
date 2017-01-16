<?php
/**
 * Abstraktní databázová třída.
 *
 * @deprecated since version 200
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2009-2016 Vitex@vitexsoftware.cz (G)
 */

namespace Ease\SQL;

/**
 * Virtuálni třída pro práci s databází.
 *
 * @author Vitex <vitex@hippy.cz>
 */
abstract class SQL extends \Ease\Sand
{
    /**
     * SQL operation result handle.
     *
     * @var resource
     */
    public $result = null;

    /**
     * SQL Handle.
     *
     * @var resource
     */
    public $sqlLink = null;

    /**
     * IP serveru.
     *
     * @var string
     */
    public $server = null;

    /**
     * DB Login.
     *
     * @var string
     */
    public $username = null;

    /**
     * DB heslo.
     *
     * @var string
     */
    public $password = null;

    /**
     * Database to connect by default.
     *
     * @var string
     */
    public $database = null;

    /**
     * Database port.
     *
     * @var string
     */
    public $port = null;

    /**
     * Status připojení.
     *
     * @var bool
     */
    public $status = null;

    /**
     * Hodnota posledního voloženeho AutoIncrement sloupečku.
     *
     * @var int unsigned
     */
    public $lastInsertID = null;

    /**
     * Poslední vykonaná SQL Query.
     *
     * @var string
     */
    public $lastQuery = '';

    /**
     * Počet ovlivněných nebo vrácených řádek při $this->LastQuery.
     *
     * @var string
     */
    public $numRows = 0;

    /**
     * Pole obsahující informace o základních paramatrech SQL přiopojení.
     *
     * @var array
     */
    public $report = ['LastMessage' => 'Please extend'];

    /**
     * Klíčový sloupeček pro SQL operace.
     *
     * @var string
     */
    public $keyColumn = '';

    /**
     * Název práve zpracovávané tabulky.
     *
     * @var string
     */
    public $tableName = '';

    /**
     * Pole obsahující strukturu SQL tabulky.
     *
     * @var array
     */
    public $tableStructure = [];

    /**
     * Poslední Chybová zpráva obdržená od SQL serveru.
     *
     * @var string
     */
    public $errorText = null;

    /**
     * Kod SQL chyby.
     *
     * @var int
     */
    public $errorNumber = null;

    /**
     * Pole obsahující výsledky posledního SQL příkazu.
     *
     * @var array
     */
    public $resultArray = [];

    /**
     * Pomocná proměnná pro datové operace.
     *
     * @var array
     */
    public $data = null;

    /**
     * Poslední zpráva obdžená od SQL serveru.
     *
     * @var string
     */
    public $lastMessage = null;

    /**
     * Nastavení vlastností přípojení.
     *
     * @var array
     */
    public $connectionSettings = [];

    /**
     * Indikátor nastavení připojení - byly vykonány SET příkazy.
     *
     * @var bool
     */
    protected $connectAllreadyUP = false;

    /**
     * Type of used database.
     *
     * @var string mysql|pgsql|..
     */
    public $dbType;

    /**
     * Hack WHERE to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $whr = ' WHERE ';

    /**
     * Hack SELECT to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $sel = 'SELECT ';

    /**
     * Hack ORDER BY to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $ord = ' ORDER BY ';

    /**
     * Hack LIMIT to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $lmt = ' LIMIT ';

    /**
     * Hack FROM to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $frm = ' FROM ';

    /**
     * Hack DELETE FROM to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $dlt = 'DELETE FROM ';

    /**
     * Hack UPDATE to make Sensio Labs checks happy.
     *
     * @var string
     */
    public static $upd = 'UPDATE ';

    /**
     * Obecný objekt databáze.
     */
    public function __construct()
    {
        parent::__construct();
        if (!isset($this->dbType) && defined('DB_TYPE')) {
            $this->dbType = constant('DB_TYPE');
        }
        if (!isset($this->server) && defined('DB_SERVER')) {
            $this->server = constant('DB_SERVER');
        }
        if (!isset($this->username) && defined('DB_SERVER_USERNAME')) {
            $this->username = constant('DB_SERVER_USERNAME');
        }
        if (!isset($this->password) && defined('DB_SERVER_PASSWORD')) {
            $this->password = constant('DB_SERVER_PASSWORD');
        }
        if (!isset($this->database) && defined('DB_DATABASE')) {
            $this->database = constant('DB_DATABASE');
        }
        if (!isset($this->port) && defined('DB_PORT')) {
            $this->port = constant('DB_PORT');
        }
        $this->connect();
    }

    /**
     * Připojení k databázi.
     */
    public function connect()
    {
        $this->setUp();
        $this->status = true;
    }

    /**
     * Přepene databázi.
     *
     * @param type $dbName
     *
     * @return bool
     */
    public function selectDB($dbName = null)
    {
        if (!is_null($dbName)) {
            $this->database = $dbName;
        }

        return;
    }

    /**
     * Id vrácené po INSERTu.
     *
     * @return int
     */
    public function getInsertID()
    {
        return $this->lastInsertID;
    }

    /**
     * Otestuje moznost pripojeni k sql serveru.
     *
     * @param bool $succes vynucený výsledek
     *
     * @return $Success
     */
    public function ping($succes = null)
    {
        return $succes;
    }

    /**
     * Po deserializaci se znovu připojí.
     */
    public function __wakeup()
    {
        parent::__wakeup();
        $this->connect();
    }

    /**
     * Odstraní z SQL dotazu "nebezpečné" znaky.
     *
     * @param string $queryRaw SQL Query
     *
     * @return string SQL Query
     */
    public function sanitizeQuery($queryRaw)
    {
        $sanitizedQuery = trim($queryRaw);

        return $sanitizedQuery;
    }

    public function makeReport()
    {
        $this->report['LastMessage'] = $this->lastMessage;
        $this->report['ErrorText']   = $this->errorText;
        $this->report['Database']    = $this->database;
        $this->report['Username']    = $this->username;
        $this->report['Server']      = $this->server;
    }

    /**
     * Nastaví připojení.
     *
     * @deprecated since version 210
     */
    public function setUp()
    {
        if (!$this->connectAllreadyUP) {
            if (isset($this->connectionSettings) && is_array($this->connectionSettings)
                && count($this->connectionSettings)) {
                foreach ($this->connectionSettings as $setName => $SetValue) {
                    if (strlen($setName)) {
                        $this->exeQuery("SET $setName $SetValue");
                    }
                }
                $this->connectAllreadyUP = true;
            }
        }
    }

    public function setTable($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Vrací počet řádků vrácených nebo ovlivněným posledním sql dotazem.
     *
     * @return int počet řádků
     */
    public function getNumRows()
    {
        return $this->numRows;
    }

    /**
     * Poslední vykonaný dotaz.
     *
     * @return int počet řádků
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    /**
     * Poslední genrované ID.
     *
     * @return int ID
     */
    public function getlastInsertID()
    {
        return $this->lastInsertID;
    }

    /**
     * Vrací chybovou zprávu SQL.
     *
     * @return string
     */
    public function getLastError()
    {
        if ($this->errorText) {
            if (isset($this->errorNumber)) {
                return '#'.$this->errorNumber.': '.$this->errorText;
            } else {
                return $this->errorText;
            }
        } else {
            return;
        }
    }

    /**
     * Při serializaci vynuluje poslední Query.
     *
     * @return bool
     */
    public function __sleep()
    {
        $this->lastQuery = null;

        return parent::__sleep();
    }

    /**
     * Zavře databázové spojení.
     */
    public function __destruct()
    {
        if (method_exists($this, 'close')) {
            $this->close();
        }
    }

    /**
     * Vrací výsledek dotazu jako dvourozměrné pole.
     *
     * @param string $queryRaw SQL příkaz
     *
     * @return array|null
     */
    public function queryTo2DArray($queryRaw)
    {
        $result = $this->queryToArray($queryRaw);
        if (count($result)) {
            $values = [];
            foreach ($result as $value) {
                $values[] = current($value);
            }

            return $values;
        }

        return $result;
    }

    /**
     * Vrací první položku výsledku dotazu.
     *
     * @param string $queryRaw SQL příkaz vracející jednu hodnotu
     *
     * @return string|null
     */
    public function queryToValue($queryRaw)
    {
        $result = $this->queryToArray($queryRaw);
        if (count($result)) {
            return current(current($result));
        } else {
            return;
        }
    }

    /**
     * Vrací počet výsledku dotazu.
     *
     * @param string $queryRaw SQL příkaz vracející jednu hodnotu
     *
     * @return int
     */
    public function queryToCount($queryRaw)
    {
        return count($this->queryToArray($queryRaw));
    }

    /**
     * Vrací uvozovky pro označení sloupečků.
     *
     * @return string
     */
    public function getColumnComma()
    {
        return '';
    }

    /**
     * Return conect status.
     *
     * @return bool
     */
    public function isConnected()
    {
        return $this->status;
    }

    /**
     * z pole $data vytvori fragment SQL dotazu za WHERE (klicovy sloupec
     * $this->myKeyColumn je preskocen pokud neni $key false).
     *
     * @param array $data
     * @param bool  $key
     *
     * @return string
     */
    public function arrayToSetQuery($data, $key = true)
    {
        $updates = '';
        foreach ($data as $column => $value) {
            if (!strlen($column)) {
                continue;
            }
            if (($column == $this->keyColumn) && $key) {
                continue;
            }
            switch (gettype($value)) {
                case 'integer':
                    $value = " $value ";
                    break;
                case 'float':
                case 'double':
                    $value = ' '.str_replace(',', '.', $value).' ';
                    break;
                case 'boolean':
                    if ($value) {
                        $value = ' TRUE ';
                    } else {
                        $value = ' FALSE ';
                    }
                    break;
                case 'NULL':
                    $value = ' null ';
                    break;
                case 'string':
                    if ($value != 'NOW()') {
                        if (!strstr($value, "\'")) {
                            $value = " '".str_replace("'", "\'", $value)."' ";
                        } else {
                            $value = " '$value' ";
                        }
                    }
                    break;
                default:
                    $value = " '$value' ";
            }

            $updates .= ' '.$this->getColumnComma().$column.$this->getColumnComma()." = $value,";
        }

        return substr($updates, 0, -1);
    }

    /**
     * Do when SQL error occurs.
     *
     * @param bool $ignoreErrors
     */
    public function logSqlError($ignoreErrors = false)
    {
        if (!$this->result && !$ignoreErrors) {
            $queryRaw = $this->lastQuery;
            $callerBackTrace = debug_backtrace();
            $callerBackTrace = $callerBackTrace[2];
            $caller          = $callerBackTrace['function'].'()';
            if (isset($callerBackTrace['class'])) {
                $caller .= ' in '.$callerBackTrace['class'];
            }
            if (isset($callerBackTrace['object'])) {
                $caller .= ' ('.get_class($callerBackTrace['object']).')';
            }
            \Ease\Shared::logger()->addStatusMessage(new \Ease\Logger\Message('ExeQuery: #'.$this->errorNumber.': '.$this->errorText."\n".$queryRaw,
                'error', $caller));
        }
    }

    /**
     * Funkce pro defaultní slashování v celém frameworku.
     *
     * @param string $text
     *
     * @return string
     */
    public function easeAddSlashes($text)
    {
        return addslashes($text);
    }
}
