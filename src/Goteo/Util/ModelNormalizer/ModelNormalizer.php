<?php
/*
 * This file is part of the Goteo Package.
 *
 * (c) Platoniq y Fundación Goteo <fundacion@goteo.org>
 *
 * For the full copyright and license information, please view the README.md
 * and LICENSE files that was distributed with this source code.
 */
namespace Goteo\Util\ModelNormalizer;

use Goteo\Core\Model as CoreModel;
use Goteo\Model;
use Goteo\Util\ModelNormalizer\Transformer;
use Goteo\Application\Session;
/**
 * This class allows to get an object standarized for its use in views
 */
class ModelNormalizer {
    private $model;
    private $keys;

    public function __construct(CoreModel $model,array $keys = null) {
        $this->model = $model;
        $this->keys = $keys;
    }

    /**
     * Returns the normalized object
     * @return Goteo\Util\ModelNormalizer\TransformerInterface
     */
    public function get() {
        if($this->model instanceOf Model\User) {
            $ob = new Transformer\UserTransformer($this->model, $this->keys);
        }
        elseif($this->model instanceOf Model\Stories) {
            $ob = new Transformer\StoriesTransformer($this->model, $this->keys);
        }
        elseif(
            $this->model instanceOf Model\Category
            || $this->model instanceOf Model\Sphere
            || $this->model instanceOf Model\SocialCommitment
            || $this->model instanceOf Model\Footprint
            || $this->model instanceOf Model\Sdg
        ) {
            $ob = new Transformer\CategoriesTransformer($this->model, $this->keys);
        }
        elseif($this->model instanceOf Model\Blog\Post) {
            $ob = new Transformer\PostTransformer($this->model, $this->keys);
        }
        else $ob = new Transformer\GenericTransformer($this->model, $this->keys);

        $ob->setUser(Session::getUser())->rebuild();

        return $ob;
    }
}
