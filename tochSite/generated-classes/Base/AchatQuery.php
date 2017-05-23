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
 * Base class that represents a query for the 'ACHAT' table.
 *
 *
 *
 * @method     ChildAchatQuery orderByDateAchat($order = Criteria::ASC) Order by the date_achat column
 * @method     ChildAchatQuery orderByPseudo($order = Criteria::ASC) Order by the pseudo column
 * @method     ChildAchatQuery orderByPasswd($order = Criteria::ASC) Order by the passwd column
 * @method     ChildAchatQuery orderByIdPack($order = Criteria::ASC) Order by the id_pack column
 *
 * @method     ChildAchatQuery groupByDateAchat() Group by the date_achat column
 * @method     ChildAchatQuery groupByPseudo() Group by the pseudo column
 * @method     ChildAchatQuery groupByPasswd() Group by the passwd column
 * @method     ChildAchatQuery groupByIdPack() Group by the id_pack column
 *
 * @method     ChildAchatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAchatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAchatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAchatQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildAchatQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildAchatQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildAchatQuery leftJoinPackjeton($relationAlias = null) Adds a LEFT JOIN clause to the query using the Packjeton relation
 * @method     ChildAchatQuery rightJoinPackjeton($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Packjeton relation
 * @method     ChildAchatQuery innerJoinPackjeton($relationAlias = null) Adds a INNER JOIN clause to the query using the Packjeton relation
 *
 * @method     \UserQuery|\PackjetonQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAchat findOne(ConnectionInterface $con = null) Return the first ChildAchat matching the query
 * @method     ChildAchat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAchat matching the query, or a new ChildAchat object populated from the query conditions when no match is found
 *
 * @method     ChildAchat findOneByDateAchat(string $date_achat) Return the first ChildAchat filtered by the date_achat column
 * @method     ChildAchat findOneByPseudo(string $pseudo) Return the first ChildAchat filtered by the pseudo column
 * @method     ChildAchat findOneByPasswd(string $passwd) Return the first ChildAchat filtered by the passwd column
 * @method     ChildAchat findOneByIdPack(int $id_pack) Return the first ChildAchat filtered by the id_pack column *

 * @method     ChildAchat requirePk($key, ConnectionInterface $con = null) Return the ChildAchat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOne(ConnectionInterface $con = null) Return the first ChildAchat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAchat requireOneByDateAchat(string $date_achat) Return the first ChildAchat filtered by the date_achat column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOneByPseudo(string $pseudo) Return the first ChildAchat filtered by the pseudo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOneByPasswd(string $passwd) Return the first ChildAchat filtered by the passwd column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAchat requireOneByIdPack(int $id_pack) Return the first ChildAchat filtered by the id_pack column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAchat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAchat objects based on current ModelCriteria
 * @method     ChildAchat[]|ObjectCollection findByDateAchat(string $date_achat) Return ChildAchat objects filtered by the date_achat column
 * @method     ChildAchat[]|ObjectCollection findByPseudo(string $pseudo) Return ChildAchat objects filtered by the pseudo column
 * @method     ChildAchat[]|ObjectCollection findByPasswd(string $passwd) Return ChildAchat objects filtered by the passwd column
 * @method     ChildAchat[]|ObjectCollection findByIdPack(int $id_pack) Return ChildAchat objects filtered by the id_pack column
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
    public function __construct($dbName = 'SITE_ENCHERES', $modelName = '\\Achat', $modelAlias = null)
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
     * $obj = $c->findPk(array(12, 34, 56, 78), $con);
     * </code>
     *
     * @param array[$date_achat, $pseudo, $passwd, $id_pack] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAchat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AchatTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3]))))) && !$this->formatter) {
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
        $sql = 'SELECT date_achat, pseudo, passwd, id_pack FROM ACHAT WHERE date_achat = :p0 AND pseudo = :p1 AND passwd = :p2 AND id_pack = :p3';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0] ? $key[0]->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_STR);
            $stmt->bindValue(':p3', $key[3], PDO::PARAM_INT);
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
            AchatTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2], (string) $key[3])));
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
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AchatTableMap::COL_DATE_ACHAT, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AchatTableMap::COL_PSEUDO, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(AchatTableMap::COL_PASSWD, $key[2], Criteria::EQUAL);
        $this->addUsingAlias(AchatTableMap::COL_ID_PACK, $key[3], Criteria::EQUAL);

        return $this;
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
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AchatTableMap::COL_DATE_ACHAT, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AchatTableMap::COL_PSEUDO, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(AchatTableMap::COL_PASSWD, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $cton3 = $this->getNewCriterion(AchatTableMap::COL_ID_PACK, $key[3], Criteria::EQUAL);
            $cton0->addAnd($cton3);
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
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByDateAchat($dateAchat = null, $comparison = null)
    {
        if (is_array($dateAchat)) {
            $useMinMax = false;
            if (isset($dateAchat['min'])) {
                $this->addUsingAlias(AchatTableMap::COL_DATE_ACHAT, $dateAchat['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateAchat['max'])) {
                $this->addUsingAlias(AchatTableMap::COL_DATE_ACHAT, $dateAchat['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_DATE_ACHAT, $dateAchat, $comparison);
    }

    /**
     * Filter the query on the pseudo column
     *
     * Example usage:
     * <code>
     * $query->filterByPseudo('fooValue');   // WHERE pseudo = 'fooValue'
     * $query->filterByPseudo('%fooValue%'); // WHERE pseudo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pseudo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByPseudo($pseudo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pseudo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pseudo)) {
                $pseudo = str_replace('*', '%', $pseudo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_PSEUDO, $pseudo, $comparison);
    }

    /**
     * Filter the query on the passwd column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswd('fooValue');   // WHERE passwd = 'fooValue'
     * $query->filterByPasswd('%fooValue%'); // WHERE passwd LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwd The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByPasswd($passwd = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwd)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwd)) {
                $passwd = str_replace('*', '%', $passwd);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_PASSWD, $passwd, $comparison);
    }

    /**
     * Filter the query on the id_pack column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPack(1234); // WHERE id_pack = 1234
     * $query->filterByIdPack(array(12, 34)); // WHERE id_pack IN (12, 34)
     * $query->filterByIdPack(array('min' => 12)); // WHERE id_pack > 12
     * </code>
     *
     * @see       filterByPackjeton()
     *
     * @param     mixed $idPack The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function filterByIdPack($idPack = null, $comparison = null)
    {
        if (is_array($idPack)) {
            $useMinMax = false;
            if (isset($idPack['min'])) {
                $this->addUsingAlias(AchatTableMap::COL_ID_PACK, $idPack['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPack['max'])) {
                $this->addUsingAlias(AchatTableMap::COL_ID_PACK, $idPack['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AchatTableMap::COL_ID_PACK, $idPack, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User $user The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAchatQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(AchatTableMap::COL_PSEUDO, $user->getPseudo(), $comparison)
                ->addUsingAlias(AchatTableMap::COL_PASSWD, $user->getPasswd(), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Filter the query by a related \Packjeton object
     *
     * @param \Packjeton|ObjectCollection $packjeton The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAchatQuery The current query, for fluid interface
     */
    public function filterByPackjeton($packjeton, $comparison = null)
    {
        if ($packjeton instanceof \Packjeton) {
            return $this
                ->addUsingAlias(AchatTableMap::COL_ID_PACK, $packjeton->getIdPack(), $comparison);
        } elseif ($packjeton instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AchatTableMap::COL_ID_PACK, $packjeton->toKeyValue('PrimaryKey', 'IdPack'), $comparison);
        } else {
            throw new PropelException('filterByPackjeton() only accepts arguments of type \Packjeton or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Packjeton relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAchatQuery The current query, for fluid interface
     */
    public function joinPackjeton($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Packjeton');

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
            $this->addJoinObject($join, 'Packjeton');
        }

        return $this;
    }

    /**
     * Use the Packjeton relation Packjeton object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PackjetonQuery A secondary query class using the current class as primary query
     */
    public function usePackjetonQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPackjeton($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Packjeton', '\PackjetonQuery');
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
            $this->addCond('pruneCond0', $this->getAliasedColName(AchatTableMap::COL_DATE_ACHAT), $achat->getDateAchat(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AchatTableMap::COL_PSEUDO), $achat->getPseudo(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(AchatTableMap::COL_PASSWD), $achat->getPasswd(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond3', $this->getAliasedColName(AchatTableMap::COL_ID_PACK), $achat->getIdPack(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2', 'pruneCond3'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ACHAT table.
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
