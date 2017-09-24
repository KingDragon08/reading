#!/usr/bin/env python  
# coding=utf-8

N = int(raw_input())
data = []

for i in range(N):
    temp = [int(i) for i in raw_input().strip().split(" ")]
    if len(data)>0:
        flag = True
        pop_index = []
        for i in range(len(data)):
            if data[i][0]>temp[0] and data[i][1]>temp[1]:
                flag = False
                break
            elif data[i][0]<temp[0] and data[i][1]<temp[1]:
                pop_index.append(i)
        if flag:
            data.append(temp)
        if len(pop_index)>0:
            for i in pop_index:
                data.pop(i)
    else:
        data.append(temp)

data = sorted(data, key=lambda x:x[0])

for item in data:
    print(str(item[0]) + " " + str(item[1]))



