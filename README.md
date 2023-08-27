# leo-blog
---
## Local build
```aidl
docker-compose -f "docker-compose.yml" up -d --build
```
### file name : leo-blog
### branches name: feature/4-schedule add checkbox

## just blog : http://localhost:8090
## admin :http://localhost:8092

## problem
- 체크 박스값이 데이터베이스로 전달이 안 됨
-  AdminLTE 사이드바에 메뉴를 추가하고 싶은데 코드를 찾지 못해, 추가 못하는 중


## how to start
1. 도커 빌드를 마친 후 http://localhost:8092에 접속<br/>
![스크린샷 2023-08-23 014900](https://github.com/thai-daunbi/leo-blog/assets/126050099/dc69d721-2419-4a49-b058-ec06ddbfb42d)

2. 회원가입<br/>
   ![스크린샷 2023-08-23 014920](https://github.com/thai-daunbi/leo-blog/assets/126050099/7ffeed5d-7ceb-4664-84f4-c753775f916e)

2. 로그인<br/>
   ![스크린샷 2023-08-23 015011](https://github.com/thai-daunbi/leo-blog/assets/126050099/f0b08375-dd50-4c0b-9b64-86a750a869e0)

4. 메인화면<br/>
![스크린샷 2023-08-23 015038](https://github.com/thai-daunbi/leo-blog/assets/126050099/f62a3d28-252e-4a67-850c-efc7faadbfe3)

5. 사이드바에 추가를 못했기 때문에 http://localhost:8092/schedule로<br/>
![스크린샷 2023-08-23 015140](https://github.com/thai-daunbi/leo-blog/assets/126050099/0bc041f6-3913-4bbf-a24a-44806db7d868)

6. 메인 스케줄 페이지<br/>
![스크린샷 2023-08-27 224629](https://github.com/thai-daunbi/leo-blog/assets/126050099/64f973d4-3495-4539-af50-607521ca23d2)

7. 왼쪽 '+'버튼을 누르면 체크박스 업데이트 가능<br/>
![스크린샷 2023-08-27 224645](https://github.com/thai-daunbi/leo-blog/assets/126050099/9c735cc8-3b2e-4aa2-9b72-7580dd7fed3e)

8. 체크박스 업데이트 화면<br/>
![스크린샷 2023-08-27 224657](https://github.com/thai-daunbi/leo-blog/assets/126050099/4ca7b951-ce47-4c56-bdb1-0430fffcf016)

9. 테이블 확인 화면<br/>
![스크린샷 2023-08-27 224741](https://github.com/thai-daunbi/leo-blog/assets/126050099/13f152d0-433d-43db-9ccd-b16e90aba0c7)





