<?php

namespace Base;

use \Achat as ChildAchat;
use \AchatQuery as ChildAchatQuery;
use \Exception;
use \PDO;
use Map\AchatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'Achat' table.
 *
 *
 *
 * @method     ChildAchatQuery orderByDateacht($order = Criteria::ASC) Order by the dateAcht column
 * @method     ChildAchatQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildAchatQuery orderById($order = Criteria::ASC) Order by the id column
 *
 * @method     ChildAchatQuery groupByDateacht() Group by the dateAcht column
 * @method     ChildAchatQuery groupByEmail() Group by the email column
 * @method     ChildAchatQuery groupById() Group by the id column
 *
 * @method     ChildAchatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAchatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAchatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAchatQuery leftJoinUtilisateur($relationAlias = null) Adds a LEFT JOIN clause to the query using the Utilisateur relation
 * @method     ChildAchatQuery rightJoinUtilisateur($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Utilisateur relation
 * @method     ChildAchatQuery innerJoinUtilisateur($relationAlias = null) Adds a INNER JOIN clause to the query using the Utilisateur relation
 *
 * @method     ChildAchatQuery leftJoinJetons($relationAlias = null) Adds a LEFT JOIN clause to the query using the Jetons relation
 * @method     ChildAchatQuery rightJoinJetons($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Jetons relation
 * @method     ChildAchatQuery innerJoinJetons($relationAlias = null) Adds a INNER JOIN clause to the query using the Jetons relation
 *
 * @method     \UtilisateurQuery|\JetonsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAchat findOne(ConnectionInterface $con = null) Return the first ChildAchat matching the query
 * @method     ChildAchat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAchat matching the query, or a new ChildAchat object populated from the query conditions when no match is found
 *
 * @method     ChildAchat findOneByDateacht(string $dateAcht) Return the first ChildAchat filtered by the dateAcht column
 * @method     ChildAchat findOneByEmail(string $email) Return the first ChildAchat filtered by the email column
 * @method     ChildAchat findOneById(int $id) Return the first ChildAchat filtered by the id column *

 * @method     ChildAchat requirePk($key, ConnectionInterface $con = null) Return the ChildAchat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOne(ConnectionInterface $con = null) Return the first ChildAchat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAchat requireOneByDateacht(string $dateAcht) Return the first ChildAchat filtered by the dateAcht column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOneByEmail(string $email) Return the first ChildAchat filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOneById(int $id) Return the first ChildAchat filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAchat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAchat objects based on current ModelCriteria
 * @method     ChildAchat[]|ObjectCollection findByDateacht(string $dateAcht) Return ChildAchat objects filtered by the dateAcht column
 * @method     ChildAchat[]|ObjectCollection findByEmail(string $email) Return ChildAchat objects filtered by the email column
 * @method     ChildAchat[]|ObjectCollection findById(int $id) Return ChildAchat objects filtered by the id column
 * @method     ChildAchat[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AchatQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\AchatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'miniprojet', $modelName = '\\Achat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAchatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAchatQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAchatQuery) {
            return $criteria;
        }
        $query = new ChildAchatQuery();
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
     * @return ChildAchat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AchatTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AchatTableMap::DATABASE_NAME);
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
     * @return ChildAchat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT dateAcht, email, id FROM Achat WHERE dateAcht = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key ? $key->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAchat $obj */
            $obj = new ChildAchat();
            $obj->hydrate($row);
            AchatTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAchat|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AchatTableMap::COL_DATEACHT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AchatTableMap::COL_DATEACHT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the dateAcht column
     *
     * Example usage:
     * <code>
     * $query->filterByDateacht('2011-03-14'); // WHERE dateAcht = '2011-03-14'
     * $query->filterByDateacht('now'); // WHERE dateAcht = '2011-03-14'
     * $query->filterByDateacht(array('max' => 'yesterday')); // WHERE dateAcht > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateacht The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByDateacht($dateacht = null, $comparison = null)
    {
        if (is_array($dateacht)) {
            $useMinMax = false;
            if (isset($dateacht['min'])) {
                $this->addUsingAlias(AchatTableMap::COL_DATEACHT, $dateacht['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateacht['max'])) {
                $this->addUsingAlias(AchatTableMap::COL_DATEACHT, $dateacht['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_DATEACHT, $dateacht, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_EMAIL, $email, $comparison);
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
     * @see       filterByJetons()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AchatTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AchatTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query by a related \Utilisateur object
     *
     * @param \Utilisateur|ObjectCollection $utilisateur The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAchatQuery The current query, for fluid interface
     */
    public function filterByUtilisateur($utilisateur, $comparison = null)
    {
        if ($utilisateur instanceof \Utilisateur) {
            return $this
                ->addUsingAlias(AchatTableMap::COL_EMAIL, $utilisateur->getEmail(), $comparison);
        } elseif ($utilisateur instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AchatTableMap::COL_EMAIL, $utilisateur->toKeyValue('PrimaryKey', 'Email'), $comparison);
        } else {
            throw new PropelException('filterByUtilisateur() only accepts arguments of type \Utilisateur or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Utilisateur relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function joinUtilisateur($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Utilisateur');

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
            $this->addJoinObject($join, 'Utilisateur');
        }

        return $this;
    }

    /**
     * Use the Utilisateur relation Utilisateur object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UtilisateurQuery A secondary query class using the current class as primary query
     */
    public function useUtilisateurQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUtilisateur($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Utilisateur', '\UtilisateurQuery');
    }

    /**
     * Filter the query by a related \Jetons object
     *
     * @param \Jetons|ObjectCollection $jetons The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAchatQuery The current query, for fluid interface
     */
    public function filterByJetons($jetons, $comparison = null)
    {
        if ($jetons instanceof \Jetons) {
            return $this
                ->addUsingAlias(AchatTableMap::COL_ID, $jetons->getId(), $comparison);
        } elseif ($jetons instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AchatTableMap::COL_ID, $jetons->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJetons() only accepts arguments of type \Jetons or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Jetons relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function joinJetons($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Jetons');

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
            $this->addJoinObject($join, 'Jetons');
        }

        return $this;
    }

    /**
     * Use the Jetons relation Jetons object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \JetonsQuery A secondary query class using the current class as primary query
     */
    public function useJetonsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJetons($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Jetons', '\JetonsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAchat $achat Object to remove from the list of results
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function prune($achat = null)
    {
        if ($achat) {
            $this->addUsingAlias(AchatTableMap::COL_DATEACHT, $achat->getDateacht(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the Achat table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AchatTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AchatTableMap::clearInstancePool();
            AchatTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AchatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AchatTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AchatTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AchatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AchatQuery
