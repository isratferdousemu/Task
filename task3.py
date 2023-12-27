def find_indices_with_sum(numbers, target_sum):
    left, right = 0, len(numbers) - 1

    while left < right:
        current_sum = numbers[left] + numbers[right]

        if current_sum == target_sum:
            return left, right
        elif current_sum < target_sum:
            left += 1
        else:
            right -= 1

    return None


numbers_list = [1, 2, 4, 7, 11, 15]
target = 11

result = find_indices_with_sum(numbers_list, target)

if result is not None:
    index1, index2 = result
    print(f"Indices with sum {target}: {index1}, {index2}")
else:
    print(f"No indices found with sum {target}")