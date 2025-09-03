const array = [12, 0, 1, 14, 23]

function quickSort(arr) {
    let pivot = arr[0];
    let left = [];
    let right = [];

    if (arr.length < 2) {
        return false;
    }

    for (let i = 1; i < arr.length; i++) {
        if (arr[i] > pivot) {
            left.push(arr[i])
        } else {
            right.push(arr[i])
        }
    }
    return [...quickSort(left), pivot, ...quickSort(right)]
}


// const sortedArray = quickSort(array)

// console.log(sortedArray)



function binarySearch(arr, target) {
    if (arr.length < 2) {
        console.log('Empty Array')
    } else {
        let mid = Math.floor(arr.length / 2);
        let left = arr.slice(0, mid);
        let right = arr.slice(mid);
        if (target === arr[mid]) {
            console.log(`Search element is found at index ${mid}`);
            return true
        }
        if (target > arr[mid]) {
            binarySearch(right, target)
        } else {
            binarySearch(left, target)
        }
    }
}


// let array1 = [1, 2, 3, 4, 5, 6, 7];
// const search = binarySearch(array1, 6)

// console.log(search)

function linearSearch(arr, target) {
    for(let i=0; i<arr.length; i++){
        if(arr[i] !== target){
            return -1
        } else {
            console.log(`Searched Element found at index ${i}, value is ${arr[i]}`);
        }
    }
}

let array2 = [1, 2, 3, 4, 5, 6, 7];
const linear_search = linearSearch(array2, 1)

// console.log(linear_search)


// for(let i=0; i<3; i++){
//     console.log(i)
// }

for(var i=0; i<3; i++){
    console.log(i)
}



