# leo-blog
---
## Local build
```aidl
docker-compose -f "docker-compose.yml" up -d --build
```
### 각 폴더에서 (laravel, admin) composer.json패키지 설치
```aidl
composer install
```
### 각 폴더에서 (laravel, admin) package.json패키지 설치
```aidl
npm install
```
### Start the development server
```aidl
npm run dev
```
### Database seed (admin폴더에서 실행)
```aidl
php artisan db:seed
```
### file name : leo-blog
### branches name: feature/4-schedule add checkbox

## just blog : http://localhost:8090
## admin :http://localhost:8092

## problem


## how to start
1. 도커 빌드를 마친 후 http://localhost:8092에 접속<br/>
![스크린샷 2023-08-23 014900](https://github.com/thai-daunbi/leo-blog/assets/126050099/dc69d721-2419-4a49-b058-ec06ddbfb42d)

2. 회원가입<br/>
   ![스크린샷 2023-08-23 014920](https://github.com/thai-daunbi/leo-blog/assets/126050099/7ffeed5d-7ceb-4664-84f4-c753775f916e)

2. 로그인<br/>
   ![스크린샷 2023-08-23 015011](https://github.com/thai-daunbi/leo-blog/assets/126050099/f0b08375-dd50-4c0b-9b64-86a750a869e0)

4. 메인화면<br/>
![스크린샷 2023-08-23 015038](https://github.com/thai-daunbi/leo-blog/assets/126050099/f62a3d28-252e-4a67-850c-efc7faadbfe3)

5. 메인 스케줄 페이지<br/>
![스크린샷 2023-09-02 014740](https://github.com/thai-daunbi/leo-blog/assets/126050099/0586c5cd-b286-4cf6-8a06-0c280e92ab64)

6. 왼쪽 '+'버튼을 누르면 체크박스 업데이트 가능<br/>
![스크린샷 2023-09-02 014746](https://github.com/thai-daunbi/leo-blog/assets/126050099/805ec674-0a9d-4036-8fc3-76db46b47cab)

7. 체크박스 업데이트 화면<br/>
![스크린샷 2023-09-02 014756](https://github.com/thai-daunbi/leo-blog/assets/126050099/6611cb9d-3761-4cb2-a473-111dbd987a46)

8. 테이블 확인 화면<br/>
![스크린샷 2023-08-27 224741](https://github.com/thai-daunbi/leo-blog/assets/126050099/64fe7580-c741-40c0-b47e-0678d40bf03e)

9. 스케줄 화면
![스크린샷 2023-09-01 211936](https://github.com/thai-daunbi/leo-blog/assets/126050099/e2708e49-5ea8-416b-adb3-b5479e03d3a1)





