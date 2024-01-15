<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Panic model",
 *     description="Panic model",
 * )
 */
class Panic extends Model
{
    use HasFactory;


    protected $table = 'panic_alerts';

    /**
     * @OA\Property(
     *     format="int64",
     *     description="category id",
     *     title="id",
     * )
     *
     * @var int
     */
    private $id;

    /**
     * @OA\Property(
     *     description="longitude",
     *     title="longitude",
     *     example="28.0559616"
     * )
     *
     * @var string
     */
    private $longitude;

    /**
     * @OA\Property(
     *     description="latitude",
     *     title="latitude",
     *    example="-26.099712"
     * )
     *
     * @var string
     */
    private $latitude;

    /**
     * @OA\Property(
     *     description="latitude",
     *     title="latitude",
     *     example="robbery"
     * )
     *
     * @var string
     */
    private $panic_type;

    /**
     * @OA\Property(
     *     description="details",
     *     title="details",
     *     example="robbery under way down town"
     * )
     *
     * @var string
     */
    private $details;

     /**
      * @OA\Property(
      *     description="reference_id",
      *     title="reference_id",
      *     example="6"
      * )
      *
      * @var integer
      */
    private $reference_id;

    /**
     * @OA\Property(
     *     description="panic_id",
     *     title="panic_id",
     *     example="674"
     * )
     *
     * @var integer
     */
    private $panic_id;

    /**
     * @OA\Property(
     *     example="2023-03-28 17:50:45",
     *     format="datetime",
     *     description="Panic created date",
     *     title="created_at",
     * )
     *
     * @var string
     */
    private $created_at;

    /**
     * @OA\Property(
     *     example="2023-03-28 17:50:45",
     *     format="datetime",
     *     description="Panic updated date",
     *     title="updated_at",
     * )
     *
     * @var string
     */
    private $updated_at;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getPanicId()
    {
        return Panic::where('user_id', Auth::id())
            ->select('panic_id')
            ->get()
            ->last();
    }

    public static function getNotificationHistoryForUser()
    {
        return Panic::where('user_id', Auth::id())
            ->with('user')
            ->get();

    }


}
