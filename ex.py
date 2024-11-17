
import pandas as pd    
import matplotlib.pyplot as plt 


df=pd.read_csv("C:\Program Files\hibaa.csv")
date=df['cup']
meantemp=df['focus']


plt.hist(date,meantemp)
plt.title('WIND SPEED')
plt.xlabel("Wind Speed")
plt.show()