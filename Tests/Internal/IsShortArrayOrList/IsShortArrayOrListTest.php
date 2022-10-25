<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tests\Internal\IsShortArrayOrList;

use PHPCSUtils\Internal\IsShortArrayOrList;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the \PHPCSUtils\Utils\Arrays::isShortArray() and
 * the \PHPCSUtils\Utils\Lists::isShortList() methods.
 *
 * @group arrays
 * @group lists
 *
 * @since 1.0.0
 */
final class IsShortArrayOrListTest extends UtilityMethodTestCase
{

    /**
     * Test whether a T_OPEN_SHORT_ARRAY token is correctly determined to be a short array,
     * a short list or a real square bracket.
     *
     * @dataProvider dataIsShortArrayOrList
     * @covers       \PHPCSUtils\Internal\IsShortArrayOrList
     *
     * @param string           $testMarker The comment which prefaces the target token in the test file.
     * @param string           $expected   The expected return value.
     * @param int|string|array $targetType The token type(s) to test. Defaults to T_OPEN_SHORT_ARRAY.
     *
     * @return void
     */
    public function testIsShortArrayOrList($testMarker, $expected, $targetType = \T_OPEN_SHORT_ARRAY)
    {
        $stackPtr = $this->getTargetToken($testMarker, $targetType);
        $solver   = new IsShortArrayOrList(self::$phpcsFile, $stackPtr);
        $type     = $solver->solve();

        $this->assertSame($expected, $type);
    }

    /**
     * Data provider.
     *
     * @see testIsShortArrayOrList() For the array format.
     *
     * @return array
     */
    public function dataIsShortArrayOrList()
    {
        return [
            'square-brackets' => [
                'testMarker' => '/* testSquareBrackets */',
                'expected'   => IsShortArrayOrList::SQUARE_BRACKETS,
                'targetType' => \T_OPEN_SQUARE_BRACKET,
            ],
            'short-array-not-nested' => [
                'testMarker' => '/* testShortArrayNonNested */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-comparison-no-assignment' => [
                'testMarker' => '/* testShortArrayInComparison */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-comparison-no-assignment-nested' => [
                'testMarker' => '/* testShortArrayNestedInComparison */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-union-before' => [
                'testMarker' => '/* testShortArrayUnionFirst */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-union-after' => [
                'testMarker' => '/* testShortArrayUnionSecond */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-equal-before' => [
                'testMarker' => '/* testShortArrayEqualFirst */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-equal-after' => [
                'testMarker' => '/* testShortArrayEqualSecond */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-identical-before' => [
                'testMarker' => '/* testShortArrayIdenticalFirst */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-identical-after' => [
                'testMarker' => '/* testShortArrayIdenticalSecond */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-not-equal-before' => [
                'testMarker' => '/* testShortArrayNotEqualFirst */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-not-equal-after' => [
                'testMarker' => '/* testShortArrayNotEqualSecond */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-not-equal-brackets-before' => [
                'testMarker' => '/* testShortArrayNotEqualBracketsFirst */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-not-equal-brackets-after' => [
                'testMarker' => '/* testShortArrayNotEqualBracketsSecond */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-not-identical-before' => [
                'testMarker' => '/* testShortArrayNonIdenticalFirst */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-not-identical-after' => [
                'testMarker' => '/* testShortArrayNonIdenticalSecond */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-list-in-foreach' => [
                'testMarker' => '/* testShortListInForeach */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list' => [
                'testMarker' => '/* testShortList */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-multi-item' => [
                'testMarker' => '/* testShortListMultiItem */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-with-keys' => [
                'testMarker' => '/* testShortListWithKeys */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-with-nesting' => [
                'testMarker' => '/* testShortListWithNesting */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-nested' => [
                'testMarker' => '/* testShortListNested */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-in-chained-assignment' => [
                'testMarker' => '/* testShortlistMultiAssign */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-array-in-chained-assignment' => [
                'testMarker' => '/* testShortArrayMultiAssign */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-with-nesting-and-keys' => [
                'testMarker' => '/* testShortArrayWithNestingAndKeys */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-nested-with-keys-1' => [
                'testMarker' => '/* testNestedShortArrayWithKeys_1 */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-nested-with-keys-2' => [
                'testMarker' => '/* testNestedShortArrayWithKeys_2 */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-nested-with-keys-3' => [
                'testMarker' => '/* testNestedShortArrayWithKeys_3 */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-nested-unpacking-without-keys-php74' => [
                'testMarker' => '/* testNestedShortArrayPHP74UnpackingWithoutKeys */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-array-nested-unpacking-with-keys-php81' => [
                'testMarker' => '/* testNestedShortArrayPHP81UnpackingWithKeys */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'short-list-with-nesting-and-keys' => [
                'testMarker' => '/* testShortListWithNestingAndKeys */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-nested-with-keys-1' => [
                'testMarker' => '/* testNestedShortListWithKeys_1 */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-nested-with-keys-2' => [
                'testMarker' => '/* testNestedShortListWithKeys_2 */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-nested-with-keys-3' => [
                'testMarker' => '/* testNestedShortListWithKeys_3 */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-deeply-nested' => [
                'testMarker' => '/* testDeeplyNestedShortList */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-in-braced-control-structure' => [
                'testMarker' => '/* testShortListInBracedControlStructure */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-in-alternative-control-structure' => [
                'testMarker' => '/* testShortListInAlternativeControlStructure */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],

            'short-array-in-arrow-fn-return-expression' => [
                'testMarker' => '/* testShortArrayInShortArrowFunction */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],

            // Invalid syntaxes.
            'short-list-nested-empty' => [
                'testMarker' => '/* testNestedShortListEmpty */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-without-vars' => [
                'testMarker' => '/* testShortListWithoutVars */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'short-list-nested-long-list' => [
                'testMarker' => '/* testShortListNestedLongList */',
                'expected'   => IsShortArrayOrList::SHORT_LIST,
            ],
            'parse-error-anon-class-trait-use-as' => [
                'testMarker' => '/* testNestedAnonClassWithTraitUseAs */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'parse-error-use-as' => [
                'testMarker' => '/* testParseError */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
            'parse-error-live-coding' => [
                'testMarker' => '/* testLiveCodingNested */',
                'expected'   => IsShortArrayOrList::SHORT_ARRAY,
            ],
        ];
    }
}
