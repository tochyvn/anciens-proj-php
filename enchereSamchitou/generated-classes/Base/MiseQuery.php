<?php

namespace Base;

use \Mise as ChildMise;
use \MiseQuery as ChildMiseQuery;
use \Exception;
use \PDO;
use Map\MiseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'mise' table.
 *
 *
 *
 * @method     ChildMiseQuery orderByDateMise($order = Criteria::ASC) Order by the date_mise column
 * @method     ChildMiseQuery orderByPrixMise($order = Criteria::ASC) Order by the prix_mise column
 * @method     ChildMiseQuery orderByIdEnchere($order = Criteria::ASC) Order by the id_enchere column
 * @method     ChildMiseQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 *
 * @method     ChildMiseQuery groupByDateMise() Group by the date_mise column
 * @method     ChildMiseQuery groupByPrixMise() Group by the prix_mise column
 * @method     ChildMiseQuery groupByIdEnchere() Group by the id_enchere column
 * @method     ChildMiseQuery groupByIdUser() Group by the id_user column
 *
 * @method     ChildMiseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMiseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMiseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMiseQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMiseQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMiseQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMise findOne(ConnectionInterface $con = null) Return the first ChildMise matching the query
 * @method     ChildMise findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMise matching the query, or a new ChildMise object populated from the query conditions when no match is found
 *
 * @method     ChildMise findOneByDateMise(string $date_mise) Return the first ChildMise filtered by the date_mise column
 * @method     ChildMise findOneByPrixMise(string $prix_mise) Return the first ChildMise filtered by the prix_mise column
 * @method     ChildMise findOneByIdEnchere(int $id_enchere) Return the first ChildMise filtered by the id_enchere column
 * @method     ChildMise findOneByIdUser(int $id_user) Return the first ChildMise filtered by the id_user column *

 * @method     ChildMise requirePk($key, ConnectionInterface $con = null) Return the ChildMise by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOne(ConnectionInterface $con = null) Return the first ChildMise matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMise requireOneByDateMise(string $date_mise) Return the first ChildMise filtered by the date_mise column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByPrixMise(string $prix_mise) Return the first ChildMise filtered by the prix_mise column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByIdEnchere(int $id_enchere) Return the first ChildMise filtered by the id_enchere column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMise requireOneByIdUser(int $id_user) Return the first ChildMise filtered by the id_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMise[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMise objects based on current ModelCriteria
 * @method     ChildMise[]|ObjectCollection findByDateMise(string $date_mise) Return ChildMise objects filtered by the date_mise column
 * @method     ChildMise[]|ObjectCollection findByPrixMise(string $prix_mise) Return ChildMise objects filtered by the prix_mise column
 * @method     ChildMise[]|ObjectCollection findByIdEnchere(int $id_enchere) Return ChildMise objects filtered by the id_enchere column
 * @method     ChildMise[]|ObjectCollection findByIdUser(int $id_user) Return ChildMise objects filtered by the id_user column
 * @method     ChildMise[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MiseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MiseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'encheres', $modelName = '\\Mise', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMiseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMiseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMiseQuery) {
            return $criteria;
        }
        $query = new ChildMiseQuery();
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
     * @param array[$prix_mise, $id_enchere, $id_user] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMise|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MiseTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MiseTableMap::DATABASE_NAME);
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
     * @return ChildMise A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT date_mise, prix_mise, id_enchere, id_user FROM mise WHERE prix_mise = :p0 AND id_enchere = :p1 AND id_user = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMise $obj */
            $obj = new ChildMise();
            $obj->hydrate($row);
            MiseTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildMise|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MiseTableMap::COL_PRIX_MISE, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MiseTableMap::COL_ID_ENCHERE, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(MiseTableMap::COL_ID_USER, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MiseTableMap::COL_PRIX_MISE, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MiseTableMap::COL_ID_ENCHERE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(MiseTableMap::COL_ID_USER, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the date_mise column
     *
     * Example usage:
     * <code>
     * $query->filterByDateMise('2011-03-14'); // WHERE date_mise = '2011-03-14'
     * $query->filterByDateMise('now'); // WHERE date_mise = '2011-03-14'
     * $query->filterByDateMise(array('max' => 'yesterday')); // WHERE date_mise > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateMise The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByDateMise($dateMise = null, $comparison = null)
    {
        if (is_array($dateMise)) {
            $useMinMax = false;
            if (isset($dateMise['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_DATE_MISE, $dateMise['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateMise['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_DATE_MISE, $dateMise['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_DATE_MISE, $dateMise, $comparison);
    }

    /**
     * Filter the query on the prix_mise column
     *
     * Example usage:
     * <code>
     * $query->filterByPrixMise(1234); // WHERE prix_mise = 1234
     * $query->filterByPrixMise(array(12, 34)); // WHERE prix_mise IN (12, 34)
     * $query->filterByPrixMise(array('min' => 12)); // WHERE prix_mise > 12
     * </code>
     *
     * @param     mixed $prixMise The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByPrixMise($prixMise = null, $comparison = null)
    {
        if (is_array($prixMise)) {
            $useMinMax = false;
            if (isset($prixMise['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_PRIX_MISE, $prixMise['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prixMise['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_PRIX_MISE, $prixMise['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_PRIX_MISE, $prixMise, $comparison);
    }

    /**
     * Filter the query on the id_enchere column
     *
     * Example usage:
     * <code>
     * $query->filterByIdEnchere(1234); // WHERE id_enchere = 1234
     * $query->filterByIdEnchere(array(12, 34)); // WHERE id_enchere IN (12, 34)
     * $query->filterByIdEnchere(array('min' => 12)); // WHERE id_enchere > 12
     * </code>
     *
     * @param     mixed $idEnchere The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByIdEnchere($idEnchere = null, $comparison = null)
    {
        if (is_array($idEnchere)) {
            $useMinMax = false;
            if (isset($idEnchere['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID_ENCHERE, $idEnchere['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idEnchere['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID_ENCHERE, $idEnchere['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_ID_ENCHERE, $idEnchere, $comparison);
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
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(MiseTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MiseTableMap::COL_ID_USER, $idUser, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMise $mise Object to remove from the list of results
     *
     * @return $this|ChildMiseQuery The current query, for fluid interface
     */
    public function prune($mise = null)
    {
        if ($mise) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MiseTableMap::COL_PRIX_MISE), $mise->getPrixMise(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MiseTableMap::COL_ID_ENCHERE), $mise->getIdEnchere(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(MiseTableMap::COL_ID_USER), $mise->getIdUser(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the mise table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MiseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MiseTableMap::clearInstancePool();
            MiseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MiseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MiseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MiseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MiseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MiseQuery
