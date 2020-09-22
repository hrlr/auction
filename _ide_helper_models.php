<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Auction
 *
 * @property int $auctionNumber
 * @property string $auctionTitle
 * @property int $auctionDuration
 * @property string $auctionStartTime
 * @property int|null $auctionSeller
 * @property string|null $auctionEndTime
 * @property int $auctionClosed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Item[] $itemsOfAuction
 * @property-read int|null $items_of_auction_count
 * @method static \Illuminate\Database\Eloquent\Builder|Auction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionSeller($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auction whereAuctionTitle($value)
 */
	class Auction extends \Eloquent {}
}

namespace App{
/**
 * App\Bid
 *
 * @property int $bidAuction
 * @property int $bidItem
 * @property string $bidAmount
 * @property int $bidUser
 * @property string $bidTime
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereBidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereBidAuction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereBidItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereBidTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bid whereBidUser($value)
 */
	class Bid extends \Eloquent {}
}

namespace App{
/**
 * App\Category
 *
 * @property int $categoryNumber
 * @property string $categoryName
 * @property int|null $categoryParent
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $allChildren
 * @property-read int|null $all_children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Category[] $children
 * @property-read int|null $children_count
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryParent($value)
 */
	class Category extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $userNumber
 * @property string $userEmail
 * @property string $userName
 * @property string $userAddress1
 * @property string|null $userAddress2
 * @property string $userPostCode
 * @property string $userCountry
 * @property string $userBirthDate
 * @property int $userStatus
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserStatus($value)
 */
	class User extends \Eloquent {}
}

