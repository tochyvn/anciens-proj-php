<?php

namespace Base;

use \Article as ChildArticle;
use \ArticleQuery as ChildArticleQuery;
use \Exception;
use \PDO;
use Map\ArticleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ARTICLE' table.
 *
 *
 *
 * @method     ChildArticleQuery orderByIdArt($order = Criteria::ASC) Order by the id_art column
 * @method     ChildArticleQuery orderByNomArt($order = Criteria::ASC) Order by the nom_art column
 * @method     ChildArticleQuery orderByPrix($order = Criteria::ASC) Order by the prix column
 * @method     ChildArticleQuery orderByPath($order = Criteria::ASC) Order by the path column
 *
 * @method     ChildArticleQuery groupByIdArt() Group by the id_art column
 * @method     ChildArticleQuery groupByNomArt() Group by the nom_art column
 * @method     ChildArticleQuery groupByPrix() Group by the prix column
 * @method     ChildArticleQuery groupByPath() Group by the path column
 *
 * @method     ChildArticleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArticleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArticleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArticleQuery leftJoinEnchere($relationAlias = null) Adds a LEFT JOIN clause to the query using the Enchere relation
 * @method     ChildArticleQuery rightJoinEnchere($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Enchere relation
 * @method     ChildArticleQuery innerJoinEnchere($relationAlias = null) Adds a INNER JOIN clause to the query using the Enchere relation
 *
 * @method     \EnchereQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildArticle findOne(ConnectionInterface $con = null) Return the first ChildArticle matching the query
 * @method     ChildArticle findOneOrCreate(ConnectionInterface $con = null) Return the first ChildArticle matching the query, or a new ChildArticle object populated from the query conditions when no match is found
 *
 * @method     ChildArticle findOneByIdArt(int $id_art) Return the first ChildArticle filtered by the id_art column
 * @method     ChildArticle findOneByNomArt(string $nom_art) Return the first ChildArticle filtered by the nom_art column
 * @method     ChildArticle findOneByPrix(string $prix) Return the first ChildArticle filtered by the prix column
 * @method     ChildArticle findOneByPath(string $path) Return the first ChildArticle filtered by the path column *

 * @method     ChildArticle requirePk($key, ConnectionInterface $con = null) Return the ChildArticle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOne(ConnectionInterface $con = null) Return the first ChildArticle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticle requireOneByIdArt(int $id_art) Return the first ChildArticle filtered by the id_art column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByNomArt(string $nom_art) Return the first ChildArticle filtered by the nom_art column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByPrix(string $prix) Return the first ChildArticle filtered by the prix column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArticle requireOneByPath(string $path) Return the first ChildArticle filtered by the path column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArticle[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildArticle objects based on current ModelCriteria
 * @method     ChildArticle[]|ObjectCollection findByIdArt(int $id_art) Return ChildArticle objects filtered by the id_art column
 * @method     ChildArticle[]|ObjectCollection findByNomArt(string $nom_art) Return ChildArticle objects filtered by the nom_art column
 * @method     ChildArticle[]|ObjectCollection findByPrix(string $prix) Return ChildArticle objects filtered by the prix column
 * @method     ChildArticle[]|ObjectCollection findByPath(string $path) Return ChildArticle objects filtered by the path column
 * @method     ChildArticle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ArticleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ArticleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'SITE_ENCHERES', $modelName = '\\Article', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArticleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArticleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildArticleQuery) {
            return $criteria;
        }
        $query = new ChildArticleQuery();
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
     * @return ChildArticle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ArticleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArticleTableMap::DATABASE_NAME);
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
     * @return ChildArticle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_art, nom_art, prix, path FROM ARTICLE WHERE id_art = :p0';
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
            /** @var ChildArticle $obj */
            $obj = new ChildArticle();
            $obj->hydrate($row);
            ArticleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildArticle|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArticleTableMap::COL_ID_ART, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArticleTableMap::COL_ID_ART, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_art column
     *
     * Example usage:
     * <code>
     * $query->filterByIdArt(1234); // WHERE id_art = 1234
     * $query->filterByIdArt(array(12, 34)); // WHERE id_art IN (12, 34)
     * $query->filterByIdArt(array('min' => 12)); // WHERE id_art > 12
     * </code>
     *
     * @param     mixed $idArt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByIdArt($idArt = null, $comparison = null)
    {
        if (is_array($idArt)) {
            $useMinMax = false;
            if (isset($idArt['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_ID_ART, $idArt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idArt['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_ID_ART, $idArt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_ID_ART, $idArt, $comparison);
    }

    /**
     * Filter the query on the nom_art column
     *
     * Example usage:
     * <code>
     * $query->filterByNomArt('fooValue');   // WHERE nom_art = 'fooValue'
     * $query->filterByNomArt('%fooValue%'); // WHERE nom_art LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nomArt The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByNomArt($nomArt = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nomArt)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nomArt)) {
                $nomArt = str_replace('*', '%', $nomArt);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_NOM_ART, $nomArt, $comparison);
    }

    /**
     * Filter the query on the prix column
     *
     * Example usage:
     * <code>
     * $query->filterByPrix(1234); // WHERE prix = 1234
     * $query->filterByPrix(array(12, 34)); // WHERE prix IN (12, 34)
     * $query->filterByPrix(array('min' => 12)); // WHERE prix > 12
     * </code>
     *
     * @param     mixed $prix The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPrix($prix = null, $comparison = null)
    {
        if (is_array($prix)) {
            $useMinMax = false;
            if (isset($prix['min'])) {
                $this->addUsingAlias(ArticleTableMap::COL_PRIX, $prix['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($prix['max'])) {
                $this->addUsingAlias(ArticleTableMap::COL_PRIX, $prix['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_PRIX, $prix, $comparison);
    }

    /**
     * Filter the query on the path column
     *
     * Example usage:
     * <code>
     * $query->filterByPath('fooValue');   // WHERE path = 'fooValue'
     * $query->filterByPath('%fooValue%'); // WHERE path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $path The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function filterByPath($path = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($path)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $path)) {
                $path = str_replace('*', '%', $path);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArticleTableMap::COL_PATH, $path, $comparison);
    }

    /**
     * Filter the query by a related \Enchere object
     *
     * @param \Enchere|ObjectCollection $enchere the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArticleQuery The current query, for fluid interface
     */
    public function filterByEnchere($enchere, $comparison = null)
    {
        if ($enchere instanceof \Enchere) {
            return $this
                ->addUsingAlias(ArticleTableMap::COL_ID_ART, $enchere->getIdArt(), $comparison);
        } elseif ($enchere instanceof ObjectCollection) {
            return $this
                ->useEnchereQuery()
                ->filterByPrimaryKeys($enchere->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEnchere() only accepts arguments of type \Enchere or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Enchere relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function joinEnchere($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Enchere');

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
            $this->addJoinObject($join, 'Enchere');
        }

        return $this;
    }

    /**
     * Use the Enchere relation Enchere object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \EnchereQuery A secondary query class using the current class as primary query
     */
    public function useEnchereQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEnchere($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Enchere', '\EnchereQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildArticle $article Object to remove from the list of results
     *
     * @return $this|ChildArticleQuery The current query, for fluid interface
     */
    public function prune($article = null)
    {
        if ($article) {
            $this->addUsingAlias(ArticleTableMap::COL_ID_ART, $article->getIdArt(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ARTICLE table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArticleTableMap::clearInstancePool();
            ArticleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ArticleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArticleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ArticleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArticleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ArticleQuery
