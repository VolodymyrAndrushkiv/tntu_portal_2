import json
from pprint import pprint
# ВИВОДЖУ
with open('formula_student.json', 'r', encoding='utf-8') as f:
    text = json.load(f)
hp = text['HP']  # Hp по компетенціях
marks = text['MARK']  # Бали виставлені по критеріям до предметів
sub = text['SUBJECTS']

r_all = []  # список щоб рахувати всі R, їх буде 4 при 4 предметах
sum_all = []  # список щоб рахувати всі Sum, їх 4 при 4 предметах
for i in range(len(marks)):
    x = [hp['HP0'], hp['HP1'],hp['HP2']]
    list_i = [(x[elem] * (max(marks[f'MARK{str(i)}']) - marks[f'MARK{str(i)}'][0])) / (
            max(marks[f'MARK{str(i)}']) - min(marks[f'MARK{str(i)}'])) for elem in range(3)]
    R = max(list_i)
    sum_i = sum(list_i)
    r_all.append(R)
    sum_all.append(sum_i)
result = {}
for i in range(len(marks)):
    formula = (0.5 * ((sum(marks[f'MARK{str(i)}']) - min(sum_all)) / (max(sum_all) - min(sum_all)))) + ((
            1 - 0.5) * ((r_all[i] - min(r_all))/(max(r_all) - min(r_all))))
    result[sub['SUB'+str(i)]] = round(formula, 3)
# print(result)

# ЗАПИСУЮ
with open('formula_student_result.json', 'w') as outfile:
    json.dump(result, outfile)