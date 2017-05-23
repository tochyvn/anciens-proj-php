<?php

namespace Base;

use \Achat as ChildAchat;
use \AchatQuery as ChildAchatQuery;
use \Mise as ChildMise;
use \MiseQuery as ChildMiseQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'USER' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the pseudo field.
     * @var        string
     */
    protected $pseudo;

    /**
     * The value for the passwd field.
     * @var        string
     */
    protected $passwd;

    /**
     * The value for the nom field.
     * @var        string
     */
    protected $nom;

    /**
     * The value for the prenom field.
     * @var        string
     */
    protected $prenom;

    /**
     * The value for the date_naiss field.
     * @var        \DateTime
     */
    protected $date_naiss;

    /**
     * The value for the pays field.
     * @var        string
     */
    protected $pays;

    /**
     * The value for the adresse field.
     * @var        string
     */
    protected $adresse;

    /**
     * The value for the telephone field.
     * @var        string
     */
    protected $telephone;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the role field.
     * @var        int
     */
    protected $role;

    /**
     * @var        ObjectCollection|ChildAchat[] Collection to store aggregation of ChildAchat objects.
     */
    protected $collAchats;
    protected $collAchatsPartial;

    /**
     * @var        ObjectCollection|ChildMise[] Collection to store aggregation of ChildMise objects.
     */
    protected $collMises;
    protected $collMisesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAchat[]
     */
    protected $achatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMise[]
     */
    protected $misesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\User object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|User The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [pseudo] column value.
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Get the [passwd] column value.
     *
     * @return string
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * Get the [nom] column value.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Get the [prenom] column value.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get the [optionally formatted] temporal [date_naiss] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateNaiss($format = NULL)
    {
        if ($format === null) {
            return $this->date_naiss;
        } else {
            return $this->date_naiss instanceof \DateTime ? $this->date_naiss->format($format) : null;
        }
    }

    /**
     * Get the [pays] column value.
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Get the [adresse] column value.
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Get the [telephone] column value.
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [role] column value.
     *
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of [pseudo] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPseudo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pseudo !== $v) {
            $this->pseudo = $v;
            $this->modifiedColumns[UserTableMap::COL_PSEUDO] = true;
        }

        return $this;
    } // setPseudo()

    /**
     * Set the value of [passwd] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPasswd($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->passwd !== $v) {
            $this->passwd = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWD] = true;
        }

        return $this;
    } // setPasswd()

    /**
     * Set the value of [nom] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setNom($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nom !== $v) {
            $this->nom = $v;
            $this->modifiedColumns[UserTableMap::COL_NOM] = true;
        }

        return $this;
    } // setNom()

    /**
     * Set the value of [prenom] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPrenom($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->prenom !== $v) {
            $this->prenom = $v;
            $this->modifiedColumns[UserTableMap::COL_PRENOM] = true;
        }

        return $this;
    } // setPrenom()

    /**
     * Sets the value of [date_naiss] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\User The current object (for fluent API support)
     */
    public function setDateNaiss($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_naiss !== null || $dt !== null) {
            if ($dt !== $this->date_naiss) {
                $this->date_naiss = $dt;
                $this->modifiedColumns[UserTableMap::COL_DATE_NAISS] = true;
            }
        } // if either are not null

        return $this;
    } // setDateNaiss()

    /**
     * Set the value of [pays] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPays($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pays !== $v) {
            $this->pays = $v;
            $this->modifiedColumns[UserTableMap::COL_PAYS] = true;
        }

        return $this;
    } // setPays()

    /**
     * Set the value of [adresse] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setAdresse($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->adresse !== $v) {
            $this->adresse = $v;
            $this->modifiedColumns[UserTableMap::COL_ADRESSE] = true;
        }

        return $this;
    } // setAdresse()

    /**
     * Set the value of [telephone] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setTelephone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->telephone !== $v) {
            $this->telephone = $v;
            $this->modifiedColumns[UserTableMap::COL_TELEPHONE] = true;
        }

        return $this;
    } // setTelephone()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [role] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setRole($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->role !== $v) {
            $this->role = $v;
            $this->modifiedColumns[UserTableMap::COL_ROLE] = true;
        }

        return $this;
    } // setRole()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Pseudo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pseudo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Passwd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->passwd = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Nom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Prenom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->prenom = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('DateNaiss', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_naiss = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('Pays', TableMap::TYPE_PHPNAME, $indexType)];
            $this->pays = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('Adresse', TableMap::TYPE_PHPNAME, $indexType)];
            $this->adresse = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UserTableMap::translateFieldName('Telephone', TableMap::TYPE_PHPNAME, $indexType)];
            $this->telephone = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UserTableMap::translateFieldName('Role', TableMap::TYPE_PHPNAME, $indexType)];
            $this->role = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\User'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAchats = null;

            $this->collMises = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->achatsScheduledForDeletion !== null) {
                if (!$this->achatsScheduledForDeletion->isEmpty()) {
                    \AchatQuery::create()
                        ->filterByPrimaryKeys($this->achatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->achatsScheduledForDeletion = null;
                }
            }

            if ($this->collAchats !== null) {
                foreach ($this->collAchats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->misesScheduledForDeletion !== null) {
                if (!$this->misesScheduledForDeletion->isEmpty()) {
                    \MiseQuery::create()
                        ->filterByPrimaryKeys($this->misesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->misesScheduledForDeletion = null;
                }
            }

            if ($this->collMises !== null) {
                foreach ($this->collMises as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_PSEUDO)) {
            $modifiedColumns[':p' . $index++]  = 'pseudo';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWD)) {
            $modifiedColumns[':p' . $index++]  = 'passwd';
        }
        if ($this->isColumnModified(UserTableMap::COL_NOM)) {
            $modifiedColumns[':p' . $index++]  = 'nom';
        }
        if ($this->isColumnModified(UserTableMap::COL_PRENOM)) {
            $modifiedColumns[':p' . $index++]  = 'prenom';
        }
        if ($this->isColumnModified(UserTableMap::COL_DATE_NAISS)) {
            $modifiedColumns[':p' . $index++]  = 'date_naiss';
        }
        if ($this->isColumnModified(UserTableMap::COL_PAYS)) {
            $modifiedColumns[':p' . $index++]  = 'pays';
        }
        if ($this->isColumnModified(UserTableMap::COL_ADRESSE)) {
            $modifiedColumns[':p' . $index++]  = 'adresse';
        }
        if ($this->isColumnModified(UserTableMap::COL_TELEPHONE)) {
            $modifiedColumns[':p' . $index++]  = 'telephone';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $modifiedColumns[':p' . $index++]  = 'role';
        }

        $sql = sprintf(
            'INSERT INTO USER (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'pseudo':
                        $stmt->bindValue($identifier, $this->pseudo, PDO::PARAM_STR);
                        break;
                    case 'passwd':
                        $stmt->bindValue($identifier, $this->passwd, PDO::PARAM_STR);
                        break;
                    case 'nom':
                        $stmt->bindValue($identifier, $this->nom, PDO::PARAM_STR);
                        break;
                    case 'prenom':
                        $stmt->bindValue($identifier, $this->prenom, PDO::PARAM_STR);
                        break;
                    case 'date_naiss':
                        $stmt->bindValue($identifier, $this->date_naiss ? $this->date_naiss->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'pays':
                        $stmt->bindValue($identifier, $this->pays, PDO::PARAM_STR);
                        break;
                    case 'adresse':
                        $stmt->bindValue($identifier, $this->adresse, PDO::PARAM_STR);
                        break;
                    case 'telephone':
                        $stmt->bindValue($identifier, $this->telephone, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'role':
                        $stmt->bindValue($identifier, $this->role, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getPseudo();
                break;
            case 1:
                return $this->getPasswd();
                break;
            case 2:
                return $this->getNom();
                break;
            case 3:
                return $this->getPrenom();
                break;
            case 4:
                return $this->getDateNaiss();
                break;
            case 5:
                return $this->getPays();
                break;
            case 6:
                return $this->getAdresse();
                break;
            case 7:
                return $this->getTelephone();
                break;
            case 8:
                return $this->getEmail();
                break;
            case 9:
                return $this->getRole();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPseudo(),
            $keys[1] => $this->getPasswd(),
            $keys[2] => $this->getNom(),
            $keys[3] => $this->getPrenom(),
            $keys[4] => $this->getDateNaiss(),
            $keys[5] => $this->getPays(),
            $keys[6] => $this->getAdresse(),
            $keys[7] => $this->getTelephone(),
            $keys[8] => $this->getEmail(),
            $keys[9] => $this->getRole(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAchats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'achats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ACHATs';
                        break;
                    default:
                        $key = 'Achats';
                }

                $result[$key] = $this->collAchats->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMises) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'mises';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'MISEs';
                        break;
                    default:
                        $key = 'Mises';
                }

                $result[$key] = $this->collMises->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPseudo($value);
                break;
            case 1:
                $this->setPasswd($value);
                break;
            case 2:
                $this->setNom($value);
                break;
            case 3:
                $this->setPrenom($value);
                break;
            case 4:
                $this->setDateNaiss($value);
                break;
            case 5:
                $this->setPays($value);
                break;
            case 6:
                $this->setAdresse($value);
                break;
            case 7:
                $this->setTelephone($value);
                break;
            case 8:
                $this->setEmail($value);
                break;
            case 9:
                $this->setRole($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPseudo($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPasswd($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNom($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPrenom($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDateNaiss($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPays($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAdresse($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setTelephone($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setEmail($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setRole($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\User The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_PSEUDO)) {
            $criteria->add(UserTableMap::COL_PSEUDO, $this->pseudo);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWD)) {
            $criteria->add(UserTableMap::COL_PASSWD, $this->passwd);
        }
        if ($this->isColumnModified(UserTableMap::COL_NOM)) {
            $criteria->add(UserTableMap::COL_NOM, $this->nom);
        }
        if ($this->isColumnModified(UserTableMap::COL_PRENOM)) {
            $criteria->add(UserTableMap::COL_PRENOM, $this->prenom);
        }
        if ($this->isColumnModified(UserTableMap::COL_DATE_NAISS)) {
            $criteria->add(UserTableMap::COL_DATE_NAISS, $this->date_naiss);
        }
        if ($this->isColumnModified(UserTableMap::COL_PAYS)) {
            $criteria->add(UserTableMap::COL_PAYS, $this->pays);
        }
        if ($this->isColumnModified(UserTableMap::COL_ADRESSE)) {
            $criteria->add(UserTableMap::COL_ADRESSE, $this->adresse);
        }
        if ($this->isColumnModified(UserTableMap::COL_TELEPHONE)) {
            $criteria->add(UserTableMap::COL_TELEPHONE, $this->telephone);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_ROLE)) {
            $criteria->add(UserTableMap::COL_ROLE, $this->role);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_PSEUDO, $this->pseudo);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getPseudo();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getPseudo();
    }

    /**
     * Generic method to set the primary key (pseudo column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setPseudo($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getPseudo();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPseudo($this->getPseudo());
        $copyObj->setPasswd($this->getPasswd());
        $copyObj->setNom($this->getNom());
        $copyObj->setPrenom($this->getPrenom());
        $copyObj->setDateNaiss($this->getDateNaiss());
        $copyObj->setPays($this->getPays());
        $copyObj->setAdresse($this->getAdresse());
        $copyObj->setTelephone($this->getTelephone());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setRole($this->getRole());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAchats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAchat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMises() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMise($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Achat' == $relationName) {
            return $this->initAchats();
        }
        if ('Mise' == $relationName) {
            return $this->initMises();
        }
    }

    /**
     * Clears out the collAchats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAchats()
     */
    public function clearAchats()
    {
        $this->collAchats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAchats collection loaded partially.
     */
    public function resetPartialAchats($v = true)
    {
        $this->collAchatsPartial = $v;
    }

    /**
     * Initializes the collAchats collection.
     *
     * By default this just sets the collAchats collection to an empty array (like clearcollAchats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAchats($overrideExisting = true)
    {
        if (null !== $this->collAchats && !$overrideExisting) {
            return;
        }
        $this->collAchats = new ObjectCollection();
        $this->collAchats->setModel('\Achat');
    }

    /**
     * Gets an array of ChildAchat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAchat[] List of ChildAchat objects
     * @throws PropelException
     */
    public function getAchats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAchatsPartial && !$this->isNew();
        if (null === $this->collAchats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAchats) {
                // return empty collection
                $this->initAchats();
            } else {
                $collAchats = ChildAchatQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAchatsPartial && count($collAchats)) {
                        $this->initAchats(false);

                        foreach ($collAchats as $obj) {
                            if (false == $this->collAchats->contains($obj)) {
                                $this->collAchats->append($obj);
                            }
                        }

                        $this->collAchatsPartial = true;
                    }

                    return $collAchats;
                }

                if ($partial && $this->collAchats) {
                    foreach ($this->collAchats as $obj) {
                        if ($obj->isNew()) {
                            $collAchats[] = $obj;
                        }
                    }
                }

                $this->collAchats = $collAchats;
                $this->collAchatsPartial = false;
            }
        }

        return $this->collAchats;
    }

    /**
     * Sets a collection of ChildAchat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $achats A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setAchats(Collection $achats, ConnectionInterface $con = null)
    {
        /** @var ChildAchat[] $achatsToDelete */
        $achatsToDelete = $this->getAchats(new Criteria(), $con)->diff($achats);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->achatsScheduledForDeletion = clone $achatsToDelete;

        foreach ($achatsToDelete as $achatRemoved) {
            $achatRemoved->setUser(null);
        }

        $this->collAchats = null;
        foreach ($achats as $achat) {
            $this->addAchat($achat);
        }

        $this->collAchats = $achats;
        $this->collAchatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Achat objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Achat objects.
     * @throws PropelException
     */
    public function countAchats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAchatsPartial && !$this->isNew();
        if (null === $this->collAchats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAchats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAchats());
            }

            $query = ChildAchatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collAchats);
    }

    /**
     * Method called to associate a ChildAchat object to this object
     * through the ChildAchat foreign key attribute.
     *
     * @param  ChildAchat $l ChildAchat
     * @return $this|\User The current object (for fluent API support)
     */
    public function addAchat(ChildAchat $l)
    {
        if ($this->collAchats === null) {
            $this->initAchats();
            $this->collAchatsPartial = true;
        }

        if (!$this->collAchats->contains($l)) {
            $this->doAddAchat($l);
        }

        return $this;
    }

    /**
     * @param ChildAchat $achat The ChildAchat object to add.
     */
    protected function doAddAchat(ChildAchat $achat)
    {
        $this->collAchats[]= $achat;
        $achat->setUser($this);
    }

    /**
     * @param  ChildAchat $achat The ChildAchat object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeAchat(ChildAchat $achat)
    {
        if ($this->getAchats()->contains($achat)) {
            $pos = $this->collAchats->search($achat);
            $this->collAchats->remove($pos);
            if (null === $this->achatsScheduledForDeletion) {
                $this->achatsScheduledForDeletion = clone $this->collAchats;
                $this->achatsScheduledForDeletion->clear();
            }
            $this->achatsScheduledForDeletion[]= clone $achat;
            $achat->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Achats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAchat[] List of ChildAchat objects
     */
    public function getAchatsJoinPackjeton(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAchatQuery::create(null, $criteria);
        $query->joinWith('Packjeton', $joinBehavior);

        return $this->getAchats($query, $con);
    }

    /**
     * Clears out the collMises collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMises()
     */
    public function clearMises()
    {
        $this->collMises = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMises collection loaded partially.
     */
    public function resetPartialMises($v = true)
    {
        $this->collMisesPartial = $v;
    }

    /**
     * Initializes the collMises collection.
     *
     * By default this just sets the collMises collection to an empty array (like clearcollMises());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMises($overrideExisting = true)
    {
        if (null !== $this->collMises && !$overrideExisting) {
            return;
        }
        $this->collMises = new ObjectCollection();
        $this->collMises->setModel('\Mise');
    }

    /**
     * Gets an array of ChildMise objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMise[] List of ChildMise objects
     * @throws PropelException
     */
    public function getMises(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMisesPartial && !$this->isNew();
        if (null === $this->collMises || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMises) {
                // return empty collection
                $this->initMises();
            } else {
                $collMises = ChildMiseQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMisesPartial && count($collMises)) {
                        $this->initMises(false);

                        foreach ($collMises as $obj) {
                            if (false == $this->collMises->contains($obj)) {
                                $this->collMises->append($obj);
                            }
                        }

                        $this->collMisesPartial = true;
                    }

                    return $collMises;
                }

                if ($partial && $this->collMises) {
                    foreach ($this->collMises as $obj) {
                        if ($obj->isNew()) {
                            $collMises[] = $obj;
                        }
                    }
                }

                $this->collMises = $collMises;
                $this->collMisesPartial = false;
            }
        }

        return $this->collMises;
    }

    /**
     * Sets a collection of ChildMise objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $mises A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setMises(Collection $mises, ConnectionInterface $con = null)
    {
        /** @var ChildMise[] $misesToDelete */
        $misesToDelete = $this->getMises(new Criteria(), $con)->diff($mises);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->misesScheduledForDeletion = clone $misesToDelete;

        foreach ($misesToDelete as $miseRemoved) {
            $miseRemoved->setUser(null);
        }

        $this->collMises = null;
        foreach ($mises as $mise) {
            $this->addMise($mise);
        }

        $this->collMises = $mises;
        $this->collMisesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Mise objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Mise objects.
     * @throws PropelException
     */
    public function countMises(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMisesPartial && !$this->isNew();
        if (null === $this->collMises || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMises) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMises());
            }

            $query = ChildMiseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collMises);
    }

    /**
     * Method called to associate a ChildMise object to this object
     * through the ChildMise foreign key attribute.
     *
     * @param  ChildMise $l ChildMise
     * @return $this|\User The current object (for fluent API support)
     */
    public function addMise(ChildMise $l)
    {
        if ($this->collMises === null) {
            $this->initMises();
            $this->collMisesPartial = true;
        }

        if (!$this->collMises->contains($l)) {
            $this->doAddMise($l);
        }

        return $this;
    }

    /**
     * @param ChildMise $mise The ChildMise object to add.
     */
    protected function doAddMise(ChildMise $mise)
    {
        $this->collMises[]= $mise;
        $mise->setUser($this);
    }

    /**
     * @param  ChildMise $mise The ChildMise object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeMise(ChildMise $mise)
    {
        if ($this->getMises()->contains($mise)) {
            $pos = $this->collMises->search($mise);
            $this->collMises->remove($pos);
            if (null === $this->misesScheduledForDeletion) {
                $this->misesScheduledForDeletion = clone $this->collMises;
                $this->misesScheduledForDeletion->clear();
            }
            $this->misesScheduledForDeletion[]= clone $mise;
            $mise->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Mises from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMise[] List of ChildMise objects
     */
    public function getMisesJoinEnchere(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMiseQuery::create(null, $criteria);
        $query->joinWith('Enchere', $joinBehavior);

        return $this->getMises($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->pseudo = null;
        $this->passwd = null;
        $this->nom = null;
        $this->prenom = null;
        $this->date_naiss = null;
        $this->pays = null;
        $this->adresse = null;
        $this->telephone = null;
        $this->email = null;
        $this->role = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collAchats) {
                foreach ($this->collAchats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMises) {
                foreach ($this->collMises as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAchats = null;
        $this->collMises = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
