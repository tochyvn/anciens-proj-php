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
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Enchere' table.
 *
 *
 *
 * @method     ChildEnchereQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildEnchereQuery orderByDatedebut($order = Criteria::ASC) Order by the dateDebut column
 * @method     ChildEnchereQuery orderByDatefin($order = Criteria::ASC) Order by the dateFin column
 * @method     ChildEnchereQuery orderByReference($order = Criteria::ASC) Order by the reference column
 * @method     ChildEnchereQuery orderByDesignation($order = Criteria::ASC) Order by the designation column
 *
 * @method     ChildEnchereQuery groupById() Group by the id column
 * @method     ChildEnchereQuery groupByDatedebut() Group by the dateDebut column
 * @method     ChildEnchereQuery groupByDatefin() Group by the dateFin column
 * @method     ChildEnchereQuery groupByReference() Group by the reference column
 * @method     ChildEnchereQuery groupByDesignation() Group by the designation column
 *
 * @method     ChildEnchereQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEnchereQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEnchereQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEnchereQuery leftJoinProduit($relationAlias = null) Adds a LEFT JOIN clause to the query using the Produit relation
 * @method     ChildEnchereQuery rightJoinProduit($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Produit relation
 * @method     ChildEnchereQuery innerJoinProduit($relationAlias = null) Adds a INNER JOIN clause to the query using the Produit relation
 *
 * @method     ChildEnchereQuery leftJoinMise($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mise relation
 * @method     ChildEnchereQuery rightJoinMise($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mise relation
 * @method     ChildEnchereQuery innerJoinMise($relationAlias = null) Adds a INNER JOIN clause to the query using the Mise relation
 *
 * @method     \ProduitQuery|\MiseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEnchere findOne(ConnectionInterface $con = null) Return the first ChildEnchere matching the query
 * @method     ChildEnchere findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEnchere matching the query, or a new ChildEnchere object populated from the query conditions when no match is found
 *
 * @method     ChildEnchere findOneById(int $id) Return the first ChildEnchere filtered by the id column
 * @method     ChildEnchere findOneByDatedebut(string $dateDebut) Return the first ChildEnchere filtered by the dateDebut column
 * @method     ChildEnchere findOneByDatefin(string $dateFin) Return the first ChildEnchere filtered by the dateFin column
 * @method     ChildEnchere findOneByReference(int $reference) Return the first ChildEnchere filtered by the reference column
 * @method     ChildEnchere findOneByDesignation(string $designation) Return the first ChildEnchere filtered by the designation column *

 * @method     ChildEnchere requirePk($key, ConnectionInterface $con = null) Return the ChildEnchere by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOne(ConnectionInterface $con = null) Return the first ChildEnchere matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEnchere requireOneById(int $id) Return the first ChildEnchere filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByDatedebut(string $dateDebut) Return the first ChildEnchere filtered by the dateDebut column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByDatefin(string $dateFin) Return the first ChildEnchere filtered by the dateFin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByReference(int $reference) Return the first ChildEnchere filtered by the reference column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEnchere requireOneByDesignation(string $designation) Return the first ChildEnchere filtered by the designation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEnchere[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEnchere objects based on current ModelCriteria
 * @method     ChildEnchere[]|ObjectCollection findById(int $id) Return ChildEnchere objects filtered by the id column
 * @method     ChildEnchere[]|ObjectCollection findByDatedebut(string $dateDebut) Return ChildEnchere objects filtered by the dateDebut column
 * @method     ChildEnchere[]|ObjectCollection findByDatefin(string $dateFin) Return ChildEnchere objects filtered by the dateFin column
 * @method     ChildEnchere[]|ObjectCollection findByReference(int $reference) Return ChildEnchere objects filtered by the reference column
 * @method     ChildEnchere[]|ObjectCollection findByDesignation(string $designation) Return ChildEnchere objects filtered by the designation column
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
    public function __construct($dbName = 'miniprojet', $modelName = '\\Enchere', $modelAlias = null)
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
        if ((null !== ($obj = EnchereTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
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
        $sql = 'SELECT id, dateDebut, dateFin, reference, designation FROM Enchere WHERE id = :p0';
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
            EnchereTableMap::addInstanceToPool($obj, (string) $key);
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

        return $this->addUsingAlias(EnchereTableMap::COL_ID, $key, Criteria::EQUAL);
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

        return $this->addUsingAlias(EnchereTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the dateDebut column
     *
     * Example usage:
     * <code>
     * $query->filterByDatedebut('2011-03-14'); // WHERE dateDebut = '2011-03-14'
     * $query->filterByDatedebut('now'); // WHERE dateDebut = '2011-03-14'
     * $query->filterByDatedebut(array('max' => 'yesterday')); // WHERE dateDebut > '2011-03-13'
     * </code>
     *
     * @param     mixed $datedebut The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByDatedebut($datedebut = null, $comparison = null)
    {
        if (is_array($datedebut)) {
            $useMinMax = false;
            if (isset($datedebut['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATEDEBUT, $datedebut['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datedebut['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATEDEBUT, $datedebut['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_DATEDEBUT, $datedebut, $comparison);
    }

    /**
     * Filter the query on the dateFin column
     *
     * Example usage:
     * <code>
     * $query->filterByDatefin('2011-03-14'); // WHERE dateFin = '2011-03-14'
     * $query->filterByDatefin('now'); // WHERE dateFin = '2011-03-14'
     * $query->filterByDatefin(array('max' => 'yesterday')); // WHERE dateFin > '2011-03-13'
     * </code>
     *
     * @param     mixed $datefin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByDatefin($datefin = null, $comparison = null)
    {
        if (is_array($datefin)) {
            $useMinMax = false;
            if (isset($datefin['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATEFIN, $datefin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datefin['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_DATEFIN, $datefin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_DATEFIN, $datefin, $comparison);
    }

    /**
     * Filter the query on the reference column
     *
     * Example usage:
     * <code>
     * $query->filterByReference(1234); // WHERE reference = 1234
     * $query->filterByReference(array(12, 34)); // WHERE reference IN (12, 34)
     * $query->filterByReference(array('min' => 12)); // WHERE reference > 12
     * </code>
     *
     * @see       filterByProduit()
     *
     * @param     mixed $reference The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByReference($reference = null, $comparison = null)
    {
        if (is_array($reference)) {
            $useMinMax = false;
            if (isset($reference['min'])) {
                $this->addUsingAlias(EnchereTableMap::COL_REFERENCE, $reference['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($reference['max'])) {
                $this->addUsingAlias(EnchereTableMap::COL_REFERENCE, $reference['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_REFERENCE, $reference, $comparison);
    }

    /**
     * Filter the query on the designation column
     *
     * Example usage:
     * <code>
     * $query->filterByDesignation('fooValue');   // WHERE designation = 'fooValue'
     * $query->filterByDesignation('%fooValue%'); // WHERE designation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $designation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByDesignation($designation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($designation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $designation)) {
                $designation = str_replace('*', '%', $designation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(EnchereTableMap::COL_DESIGNATION, $designation, $comparison);
    }

    /**
     * Filter the query by a related \Produit object
     *
     * @param \Produit|ObjectCollection $produit The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByProduit($produit, $comparison = null)
    {
        if ($produit instanceof \Produit) {
            return $this
                ->addUsingAlias(EnchereTableMap::COL_REFERENCE, $produit->getReference(), $comparison);
        } elseif ($produit instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EnchereTableMap::COL_REFERENCE, $produit->toKeyValue('Reference', 'Reference'), $comparison);
        } else {
            throw new PropelException('filterByProduit() only accepts arguments of type \Produit or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Produit relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function joinProduit($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Produit');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Produit');
        }

        return $this;
    }

    /**
     * Use the Produit relation Produit object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ProduitQuery A secondary query class using the current class as primary query
     */
    public function useProduitQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProduit($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Produit', '\ProduitQuery');
    }

    /**
     * Filter the query by a related \Mise object
     *
     * @param \Mise|ObjectCollection $mise the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEnchereQuery The current query, for fluid interface
     */
    public function filterByMise($mise, $comparison = null)
    {
        if ($mise instanceof \Mise) {
            return $this
                ->addUsingAlias(EnchereTableMap::COL_ID, $mise->getId(), $comparison);
        } elseif ($mise instanceof ObjectCollection) {
            return $this
                ->useMiseQuery()
                ->filterByPrimaryKeys($mise->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMise() only accepts arguments of type \Mise or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mise relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEnchereQuery The current query, for fluid interface
     */
    public function joinMise($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mise');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Mise');
        }

        return $this;
    }

    /**
     * Use the Mise relation Mise object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MiseQuery A secondary query class using the current class as primary query
     */
    public function useMiseQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMise($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mise', '\MiseQuery');
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
            $this->addUsingAlias(EnchereTableMap::COL_ID, $enchere->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Enchere table.
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
