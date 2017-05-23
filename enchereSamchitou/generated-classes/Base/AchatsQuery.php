<?php

namespace Base;

use \Achats as ChildAchats;
use \AchatsQuery as ChildAchatsQuery;
use \Exception;
use \PDO;
use Map\AchatsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'achats' table.
 *
 *
 *
 * @method     ChildAchatsQuery orderByDateAchat($order = Criteria::ASC) Order by the date_achat column
 * @method     ChildAchatsQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 * @method     ChildAchatsQuery orderByIdJeton($order = Criteria::ASC) Order by the id_jeton column
 *
 * @method     ChildAchatsQuery groupByDateAchat() Group by the date_achat column
 * @method     ChildAchatsQuery groupByIdUser() Group by the id_user column
 * @method     ChildAchatsQuery groupByIdJeton() Group by the id_jeton column
 *
 * @method     ChildAchatsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAchatsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAchatsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAchatsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAchatsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAchatsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAchats findOne(ConnectionInterface $con = null) Return the first ChildAchats matching the query
 * @method     ChildAchats findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAchats matching the query, or a new ChildAchats object populated from the query conditions when no match is found
 *
 * @method     ChildAchats findOneByDateAchat(string $date_achat) Return the first ChildAchats filtered by the date_achat column
 * @method     ChildAchats findOneByIdUser(int $id_user) Return the first ChildAchats filtered by the id_user column
 * @method     ChildAchats findOneByIdJeton(int $id_jeton) Return the first ChildAchats filtered by the id_jeton column *

 * @method     ChildAchats requirePk($key, ConnectionInterface $con = null) Return the ChildAchats by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchats requireOne(ConnectionInterface $con = null) Return the first ChildAchats matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAchats requireOneByDateAchat(string $date_achat) Return the first ChildAchats filtered by the date_achat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchats requireOneByIdUser(int $id_user) Return the first ChildAchats filtered by the id_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchats requireOneByIdJeton(int $id_jeton) Return the first ChildAchats filtered by the id_jeton column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAchats[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAchats objects based on current ModelCriteria
 * @method     ChildAchats[]|ObjectCollection findByDateAchat(string $date_achat) Return ChildAchats objects filtered by the date_achat column
 * @method     ChildAchats[]|ObjectCollection findByIdUser(int $id_user) Return ChildAchats objects filtered by the id_user column
 * @method     ChildAchats[]|ObjectCollection findByIdJeton(int $id_jeton) Return ChildAchats objects filtered by the id_jeton column
 * @method     ChildAchats[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AchatsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AchatsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'encheres', $modelName = '\\Achats', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAchatsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAchatsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAchatsQuery) {
            return $criteria;
        }
        $query = new ChildAchatsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$date_achat, $id_user, $id_jeton] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAchats|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AchatsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AchatsTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAchats A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT date_achat, id_user, id_jeton FROM achats WHERE date_achat = :p0 AND id_user = :p1 AND id_jeton = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0] ? $key[0]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAchats $obj */
            $obj = new ChildAchats();
            $obj->hydrate($row);
            AchatsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAchats|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAchatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AchatsTableMap::COL_DATE_ACHAT, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AchatsTableMap::COL_ID_USER, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AchatsTableMap::COL_ID_JETON, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAchatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AchatsTableMap::COL_DATE_ACHAT, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AchatsTableMap::COL_ID_USER, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AchatsTableMap::COL_ID_JETON, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the date_achat column
     *
     * Example usage:
     * <code>
     * $query->filterByDateAchat('2011-03-14'); // WHERE date_achat = '2011-03-14'
     * $query->filterByDateAchat('now'); // WHERE date_achat = '2011-03-14'
     * $query->filterByDateAchat(array('max' => 'yesterday')); // WHERE date_achat > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateAchat The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatsQuery The current query, for fluid interface
     */
    public function filterByDateAchat($dateAchat = null, $comparison = null)
    {
        if (is_array($dateAchat)) {
            $useMinMax = false;
            if (isset($dateAchat['min'])) {
                $this->addUsingAlias(AchatsTableMap::COL_DATE_ACHAT, $dateAchat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateAchat['max'])) {
                $this->addUsingAlias(AchatsTableMap::COL_DATE_ACHAT, $dateAchat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatsTableMap::COL_DATE_ACHAT, $dateAchat, $comparison);
    }

    /**
     * Filter the query on the id_user column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUser(1234); // WHERE id_user = 1234
     * $query->filterByIdUser(array(12, 34)); // WHERE id_user IN (12, 34)
     * $query->filterByIdUser(array('min' => 12)); // WHERE id_user > 12
     * </code>
     *
     * @param     mixed $idUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatsQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(AchatsTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(AchatsTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatsTableMap::COL_ID_USER, $idUser, $comparison);
    }

    /**
     * Filter the query on the id_jeton column
     *
     * Example usage:
     * <code>
     * $query->filterByIdJeton(1234); // WHERE id_jeton = 1234
     * $query->filterByIdJeton(array(12, 34)); // WHERE id_jeton IN (12, 34)
     * $query->filterByIdJeton(array('min' => 12)); // WHERE id_jeton > 12
     * </code>
     *
     * @param     mixed $idJeton The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatsQuery The current query, for fluid interface
     */
    public function filterByIdJeton($idJeton = null, $comparison = null)
    {
        if (is_array($idJeton)) {
            $useMinMax = false;
            if (isset($idJeton['min'])) {
                $this->addUsingAlias(AchatsTableMap::COL_ID_JETON, $idJeton['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idJeton['max'])) {
                $this->addUsingAlias(AchatsTableMap::COL_ID_JETON, $idJeton['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatsTableMap::COL_ID_JETON, $idJeton, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAchats $achats Object to remove from the list of results
     *
     * @return $this|ChildAchatsQuery The current query, for fluid interface
     */
    public function prune($achats = null)
    {
        if ($achats) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AchatsTableMap::COL_DATE_ACHAT), $achats->getDateAchat(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AchatsTableMap::COL_ID_USER), $achats->getIdUser(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AchatsTableMap::COL_ID_JETON), $achats->getIdJeton(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the achats table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AchatsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AchatsTableMap::clearInstancePool();
            AchatsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AchatsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AchatsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AchatsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AchatsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AchatsQuery
