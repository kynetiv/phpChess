<?php

  /**
  * This class will contain all the alive piece objects.
  *
  * PHP version 5
  *
  * @category Chess
  * @package  Board
  * @author   John Theodore <JohnTheodore@github.com>
  * @license  MIT License
  * @link     www.github.com/JOhnTheodore/phpChess
  **/

  /** 
  * This board class is instantiated inside Chess and stored as Chess->board 
  *
  * @category Chess
  * @package  Board
  * @author   John Theodore <JohnTheodore@github.com>
  * @license  MIT License
  * @link     www.github.com/JOhnTheodore/phpChess
  **/
class Board
{

  public $board;

  /** set the $board instance variable **/
  public function __construct()
  {
    $this->board = $this->getBoard();
  }

  /** 
  * for loop to make a 2d array
  * 
  * @return said 2d 8x8 array
  **/
  public function getBoard()
  {
    $empty_board = array();
    for ($i = 0; $i < 8; $i++) {
      array_push($empty_board, array_fill(0, 8, null));
    }

    return $empty_board;
  }

  /** 
  * Takes an array of pieces and adds them to the $this->board array
  * according to the position attribute of each piece
  *
  * @param array $pieces came from getChessSet() in the Chess class.
  *
  * @return void
  **/
  public function populateBoard($pieces)
  {
    foreach ($pieces as $piece) {
      $this->board[$piece->position[0]][$piece->position[1]] = $piece;
    }
  }

  /** 
  * returns a boolean for whether or not a single position is
  * on the board or not 
  *
  * @param array $position is an array with two integers (row, col), eg (0, 0)
  *
  * @return boolean
  **/
  public function isOnBoard($position)
  {
    return (preg_match('/^[0-7]+$/', $position[0]) &&
    preg_match('/^[0-7]+$/', $position[1]));
  }

  /** 
  * returns a piece object that is stored in the $this->board array 
  *
  * @param array $position is an array with two integers (row, col), eg (0, 0)
  *
  * @return object piece that was in the given $position
  **/
  public function get($position)
  {
    if ($this->IsOnBoard($position)) { 
      return $this->board[$position[0]][$position[1]]; 
    }
  }

  /** 
  * Moves a piece object from one place in the $this->board array to another 
  *
  * @param array $src  is the source position (row, col)
  * @param array $dest is the destination position (row, col)
  *
  * @return void
  **/
  public function move($src, $dest)
  {
    $mobile_piece = ($this->board[$src[0]][$src[1]]);
    $this->board[$src[0]][$src[1]] = null;
    $this->board[$dest[0]][$dest[1]] = $mobile_piece;
  }

  /** 
  * returns an array with available moves for a given color 
  *
  * @param string $color is "White" or "Black"
  *
  * @return array with all possible moves for a given color
  **/
  public function getAllPossibleMoves($color)
  {
    $allMoves = array();
    foreach ($this->board as $row) {
      foreach ($row as $square) {
        if ( (is_object($square)) && ($square->color == $color) ) {
          foreach ($square->getPossibleMoves($this) as $move) {
            array_push($allMoves, $move);
          }
        }
      }
    }
    return $allMoves;
    // this should use array_unique
  }

  /** 
  * returns the King object for a give color 
  *
  *  @param string $color is "White" or "Black"
  *
  * @return object that is the king piece of the given color
  **/
  public function findKing($color)
  {
    foreach ($this->board as $row) {
      foreach ($row as $square) {
        if ((get_class($square) == "King") && ($square->color == $color)) {
          return $square;
        }
      }
    }
  }
}

?>