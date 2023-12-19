def calculate_percentage(responses):
    total_respondents = len(responses)
    total_questions = len(responses[0])

    percentages = []

    for question_responses in responses:
        supportive_responses = question_responses[0] + question_responses[1]
        percentage = (supportive_responses / (total_respondents * 5)) * 100
        percentages.append(percentage)

    return percentages


def calculate_average_percentage(percentages):
    return sum(percentages) / len(percentages)


responses = [
    [5, 1, 0, 0, 0],
    [4, 1, 1, 0, 0],
    [4, 2, 0, 0, 0],
    [4, 2, 0, 0, 0],
    [4, 0, 1, 1, 0],
    [4, 2, 0, 0, 0],
    [4, 2, 0, 0, 0],
]

percentages = calculate_percentage(responses)
average_percentage = calculate_average_percentage(percentages)

for i, percentage in enumerate(percentages, start=1):
    print(f'Persentase Pertanyaan {i}: {percentage:.2f}%')

print(f'\nRata-rata Persentase: {average_percentage:.2f}%')
