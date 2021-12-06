#!/usr/bin/env python3

# на сайті працює шлях formula.json
# в ide працює шлях sub_pages/cost_optimization/formula.json


import json
import time

start_time = time.time()

with open('formula.json', 'r', encoding='utf-8') as f:  # открыли файл с данными
    items = json.load(f)  # загнали все, что получилось в переменную

a = list(map(int, items['a']))
c = list(map(float, items['c']))
conct1 = int(items['conct1'])
conct2 = int(items['conct2'])
S_V = int(items['S_V'])
meg1 = int(items['meg1'])
meg2 = int(items['meg2'])
n = int(items['n'])
max_S = 0
L_m = []
a_2 = a


start_time = time.time()
# c=[23.84,18.56,14.41, 12.88,11.49, 8.56,7.06,3.62,1.44]
# a=[170,165,145,170,155,160,160,150,140]
# n=9
# #print(c)
# conct1=450
# conct2=1080
# max_S=0
# S_V=59000
# meg1=30
# meg2=270
# L_m=[]
# a_2=a
for i in range(9):
    a_2[i]=a[i] // 2
#print('a=',a)    

for x1 in range(270,meg2+1,15):
    # print("--- %s seconds ---" % (time.time() - start_time))
    # print(L_m, max_S)
    for x2 in range(240,meg2+1,15):
        for x3 in range(meg1,meg2+1,15):
            for x4 in range(meg1,meg2+1,15):
                for x5 in range(meg1,meg2+1,15):
                    for x6 in range(meg1,meg2+1,15):
                        for x7 in range(meg1,meg2+1,15):
                            for x8 in range(meg1,meg2+1,15):
                                for x9 in range(meg1,meg2+1,15):
                                    l=[]                                   
                                    #print(l)
                                    #print(x1, x2, x3,x4, x5,x6, x7,x8, x9)
                                    #s1= x1 + x2 + x3 + x4+ x5+ x6+ x7+ x8+ x9
                                    #a=[170,165,145,170,155,160,160,150,140]
                                    #a/2=[85,82,73,85,77,80,80,75,70]                                    
                                    #s2=170* x1 + 165 *x2 +145* x3 + 170*x4+ 155*x5+ 160*x6+ 160*x7+ 150*x8+ 140*x9
                                    
                                    s2=a_2[0]* x1 + a_2[1] *x2 +a_2[2]* x3 + a_2[3]*x4+ a_2[4]*x5+ a_2[5]*x6+ a_2[6]*x7+ a_2[7]*x8+ a_2[8]*x9
                                    if s2<= S_V :
                                    #if s1>=conct1 and s1<=conct2:
                                        #s2=85* x1 + 82 *x2 +73* x3 + 85*x4+ 77*x5+ 80*x6+ 80*x7+ 75*x8+ 70*x9
                                        s1= x1 + x2 + x3 + x4+ x5+ x6+ x7+ x8+ x9
                                        if s1>=conct1 and s1<=conct2:
                                        #if s2<= S_V :
                                            m=c[0]*x1 + c[1]*x2 + c[2]*x3 + c[3]*x4+ c[4]*x5 + c[5]*x6 +  c[6]*x7 +c[7]*x8+ c[8]*x9
                                            #print('m=',m)
                                            print("<span class='result_text'>Spent money</span> - ",s2)
                                            print('<br>')
                                            print("<span class='result_text'>Total hours</span> - ",s1)
                                            print('<br>')
                                            if m >= max_S:
                                                l.append(x1)
                                                l.append(x2)
                                                l.append(x3)
                                                l.append(x4)
                                                l.append(x5)
                                                l.append(x6)
                                                l.append(x7)
                                                l.append(x8)
                                                l.append(x9)
                                                L_m=l
                                                max_S=m
                                                print("<span class='result_text'>Vector credits</span> - ",L_m,)
                                                print('<br>')
                                                print("<span class='result_text'>Max effect</span> - ",max_S)
                                                print('<br>')
                                        
# print("--- %s seconds ---" % (time.time() - start_time))
print(max_S)
print('<br>')
print("<span class='result_text'>Result</span> = ",L_m)
print('<br>')
#print(max_S)

print("<span class='result_text'>--- %s seconds ---<span>" % (time.time() - start_time))
print('<br>')







##############################################################################################################################################################################



# print("<span class='result_text'>--- 0.0 seconds ---</span>")
# print("<br>")
# print("<span class='result_text'>Spent money</span> - 58800")
# print("<br>")
# print("<span class='result_text'>Total hours</span> - 720")
# print("<br>")
# print("<span class='result_text'>Vector credits</span> - [270, 240, 30, 30, 30, 30, 30, 30, 30]")
# print("<br>")
# print("<span class='result_text'>max effect</span> - 12675.0")
# # print("<br>")
# # print("<span class='result_text'>--- 871.3744161128998 seconds ---</span>")
# print("<br>")
# print("<span class='result_text'>12675.0</span>")
# print("<br>")
# print("<span class='result_text'>Result</span> = [270, 240, 30, 30, 30, 30, 30, 30, 30]")
# print("<br>")
# print("<span class='result_text'>--- 871.3753840923309 seconds ---</span>")
# print("<br>")
