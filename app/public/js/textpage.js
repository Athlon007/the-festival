let areImagesSwappedForSmall = false;
let tableRowsWithImagesOnRight = document.querySelectorAll('tr td:nth-child(2) img');

// If table tr has an image that is in second column, then swap the two tds
function swapTableImg() {
    console.log('a');
    tableRowsWithImagesOnRight.forEach(function (row) {
        let rowParent = row.parentNode;
        let rowParentParent = rowParent.parentNode;
        let rowParentParentFirstChild = rowParentParent.firstChild;
        let rowParentParentLastChild = rowParentParent.lastChild;

        rowParentParent.insertBefore(rowParentParentLastChild, rowParentParentFirstChild);
    });
}

function checkResize() {
    if ($(window).width() < 960) {
        if (areImagesSwappedForSmall) {
            return;
        }
        areImagesSwappedForSmall = true;
        swapTableImg();
    }
    else {
        if (!areImagesSwappedForSmall) {
            return;
        }
        areImagesSwappedForSmall = false;
        swapTableImg();
    }
}

$(window).on('resize', function () {
    checkResize();
});