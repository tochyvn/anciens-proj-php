<?php

namespace Base;

use \Enchere as ChildEnchere;
use \EnchereQuery as ChildEnchereQuery;
use \Exception;
use \PDO;
use Map\EnchereTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'enchere' table.
 *
 *
 *
 * @method     ChildEnchereQuery orderByIdEnchere($order = Criteria::ASC) Order by the id_enchere column
 * @method     ChildEnchereQuery orderByDateDebut($order = Criteria::ASC) Order by the date_debut column
 * @method     ChildEnchereQuery orderByDateFin($order = Criteria::ASC) Order by the date_fin column
 * @method     ChildEnchereQuery orderByRefProduit($order = Criteria::ASC) Order by the ref_produit column
 *
 * @method     ChildEnchereQuery groupByIdEnchere() Group by the id_enchere column
 * @method     ChildEnchereQuery groupByDateDebut() Group by the date_debut column
 * @method     ChildEnchereQuery groupByDateFin() Group by the date_fin column
 * @method     ChildEnchereQuery groupByRefProduit() Group by the ref_produit column
 *
 * @method     ChildEnchereQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEnchereQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEnchereQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEnchereQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEnchereQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEnchereQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEnchere findOne(ConnectionInterface $con = null) Return the first ChildEnchere matching the query
 * @method     ChildEnchere findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEnchere matching the query, or a new ChildEnchere object populated from the query conditions when no match is found
 *
 * @method     ChildEnchere findOneByIdEnchere(int $id_enchere) Return the first ChildEnchere filtered by the id_enchere column
 * @method     ChildEnchere findOneByDateDebut(string $date_debut) Return the first ChildEnchere filtered by the date_debut column
 * @method     ChildEnchere findOneByDateFin(string $date_fin) Return the first ChildEnchere filtered by the date_fin column
 * @method     ChildEnchere findOneByRefProduit(int $ref_produit) Return the first ChildEnchere filtered by the ref_produit column *

 * @method     ChildEnchere requirePk($key, ConnectionInterface $con = null) Return the ChildEnchere by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOne(ConnectionInterface $con = null) Return the first ChildEnchere matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEnchere requireOneByIdEnchere(int $id_enchere) Return the first ChildEnchere filtered by the id_enchere column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByDateDebut(string $date_debut) Return the first ChildEnchere filtered by the date_debut column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByDateFin(string $date_fin) Return the first ChildEnchere filtered by the date_fin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByRefProduit(int $ref_produit) Return the first ChildEnchere filtered by the ref_produit column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEnchere[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEnchere objects based on current ModelCriteria
 * @method     ChildEnchere[]|ObjectCollection findByIdEnchere(int $id_enchere) Return ChildEnchere objects filtered by the id_enchere column
 * @method     ChildEnchere[]|ObjectCollection findByDateDebut(string $date_debut) Return ChildEnchere objects filtered by the date_debut column
 * @method     ChildEnchere[]|ObjectCollection findByDateFin(string $date_fin) Return ChildEnchere objects filtered by the date_fin column
 * @method     ChildEnchere[]|ObjectCollection findByRefProduit(int $ref_produit) Return ChildEnchere objects filtered by the ref_produit column
 * @method     ChildEnchere[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EnchereQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\EnchereQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'encheres', $modelName = '\\Enchere', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEnchereQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEnchereQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEnchereQuery) {
            return $criteria;
        }
        $query = new ChildEnchereQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildEnchere|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = EnchereTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EnchereTableMap::DATABASE_NAME);
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
     * @return ChildEnchere A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_enchere, date_debut, date_fin, ref_produit FROM enchere WHERE id_enchere = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildEnchere $obj */
            $obj = new ChildEnchere();
            $obj->hydrate($row);
            EnchereTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildEnchere|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EnchereTableMap::COL_ID_ENCHERE, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EnchereTableMap::COL_ID_ENCHERE, $keys, Criteria::IN);
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
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByIdEnchere($idEnchere = null, $comparison = null)
    {
        if (is_array($idEnchere)) {
            $useMinMax = false;
            if (isset($idEnchere['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_ID_ENCHERE, $idEnchere['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idEnchere['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_ID_ENCHERE, $idEnchere['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_ID_ENCHERE, $idEnchere, $comparison);
    }

    /**
     * Filter the query on the date_debut column
     *
     * Example usage:
     * <code>
     * $query->filterByDateDebut('2011-03-14'); // WHERE date_debut = '2011-03-14'
     * $query->filterByDateDebut('now'); // WHERE date_debut = '2011-03-14'
     * $query->filterByDateDebut(array('max' => 'yesterday')); // WHERE date_debut > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateDebut The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByDateDebut($dateDebut = null, $comparison = null)
    {
        if (is_array($dateDebut)) {
            $useMinMax = false;
            if (isset($dateDebut['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATE_DEBUT, $dateDebut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateDebut['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATE_DEBUT, $dateDebut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_DATE_DEBUT, $dateDebut, $comparison);
    }

    /**
     * Filter the query on the date_fin column
     *
     * Example usage:
     * <code>
     * $query->filterByDateFin('2011-03-14'); // WHERE date_fin = '2011-03-14'
     * $query->filterByDateFin('now'); // WHERE date_fin = '2011-03-14'
     * $query->filterByDateFin(array('max' => 'yesterday')); // WHERE date_fin > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateFin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByDateFin($dateFin = null, $comparison = null)
    {
        if (is_array($dateFin)) {
            $useMinMax = false;
            if (isset($dateFin['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATE_FIN, $dateFin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateFin['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATE_FIN, $dateFin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_DATE_FIN, $dateFin, $comparison);
    }

    /**
     * Filter the query on the ref_produit column
     *
     * Example usage:
     * <code>
     * $query->filterByRefProduit(1234); // WHERE ref_produit = 1234
     * $query->filterByRefProduit(array(12, 34)); // WHERE ref_produit IN (12, 34)
     * $query->filterByRefProduit(array('min' => 12)); // WHERE ref_produit > 12
     * </code>
     *
     * @param     mixed $refProduit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByRefProduit($refProduit = null, $comparison = null)
    {
        if (is_array($refProduit)) {
            $useMinMax = false;
            if (isset($refProduit['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_REF_PRODUIT, $refProduit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($refProduit['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_REF_PRODUIT, $refProduit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_REF_PRODUIT, $refProduit, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEnchere $enchere Object to remove from the list of results
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function prune($enchere = null)
    {
        if ($enchere) {
            $this->addUsingAlias(EnchereTableMap::COL_ID_ENCHERE, $enchere->getIdEnchere(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the enchere table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EnchereTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EnchereTableMap::clearInstancePool();
            EnchereTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EnchereTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EnchereTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EnchereTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EnchereTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EnchereQuery