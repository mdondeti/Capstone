package Tests;

import static org.testng.Assert.assertEquals;
import static org.testng.Assert.assertTrue;
import static org.testng.Assert.fail;

import java.io.FileInputStream;
import java.sql.Driver;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.concurrent.TimeUnit;

import org.testng.asserts.*;
import org.openqa.selenium.support.ui.WebDriverWait;

import org.apache.poi.ss.usermodel.CellType;
import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.junit.BeforeClass;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.annotations.*;
import Repos.RegisterPage;
import junit.framework.Assert;
import org.openqa.selenium.support.ui.ExpectedCondition ;
import org.openqa.selenium.support.ui.ExpectedConditions;
public class RegisterTest extends BaseTest {

	//private static final WebDriver driver = new FirefoxDriver();
	static XSSFWorkbook workBook; 
	static XSSFSheet sheet;
	static XSSFRow row;
	static int i=0;
	static int j=0;
	static Object[][] DataCellValues;
	WebDriver driver = new FirefoxDriver();
	//HashMap<String, String> hmap = new HashMap<String, String>();
	Boolean value = true;
	String registerValues[] = new String[5];

	public RegisterTest() {
		super();		
	}

	@DataProvider(name="registration")
	//@Test
	public static Object[][] dataInputFromExcel() throws Exception
	{
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("Register");

		int k=sheet.getLastRowNum();//get the number of rows

		int l=sheet.getRow(0).getLastCellNum();//get the number of columns in first row

		//define a string type two dimensional array
		DataCellValues = new Object[k+1][l];
		for(i=0;i<=k;i++)
		{
			row= sheet.getRow(i);
			for(j=0;j<l-1;j++)
			{
				XSSFCell cell= row.getCell(j);	
				if(row.getCell(j)==null)
				{
					DataCellValues[i][j]="";
				}
				else
				{
					DataCellValues[i][j]= new DataFormatter().formatCellValue(row.getCell(j));
				}


			}
		}
		return DataCellValues;

	}
	//	@BeforeTest
	//	public void setURL()
	//	{
	//		RegisterPage.GoToPage(driver);
	//		
	//	}

	@Test(dataProvider="registration")
	public void AssignValues(String Email,String Password,String CPassword,String FName, String LName,
			String PhoneNo,String role,String depatment,String q1Value,String a1value,String q2Value,String a2value,String q3Value,String a3value,String Value) throws Throwable
	{

		driver.get("http://wechart-test.herokuapp.com/register");

		RegisterPage.Email(driver).sendKeys(Email);
		//if email.length() == 0
		//map.add(checkEmailAlert, {"true", RegisterPage.email});
		
		
		RegisterPage.Password(driver).sendKeys(Password);
		//if password.length() == 0
		//map.add(checkPasswordAlert, "true");
		
		RegisterPage.PasswordConfirm(driver).sendKeys(CPassword);
		RegisterPage.FirstName(driver).sendKeys(FName);
		RegisterPage.LastName(driver).sendKeys(LName);
		RegisterPage.ContactNo(driver).sendKeys(PhoneNo);
		if(role.contains("Student"))
		{
			RegisterPage.StudentRole(driver).click();
		}
		else if(role.contains("Instructor"))
				{
			RegisterPage.InstructorRole(driver).click();
			
			Thread.sleep(5000);
				}
		RegisterPage.StudentRole(driver).click();	
		Select se = new Select(RegisterPage.SecurityQ1(driver));
		se.selectByValue(q1Value);
		RegisterPage.SecurityA1(driver).sendKeys(a1value);
		Select se1 = new Select(RegisterPage.SecurityQ2(driver));
		se1.selectByValue(q2Value);
		RegisterPage.SecurityA2(driver).sendKeys(a2value);
		Select se2 = new Select(RegisterPage.SecurityQ3(driver));
		se2.selectByValue(q3Value);
		RegisterPage.SecurityA3(driver).sendKeys(a3value);
		RegisterPage.Submit(driver).click();		
		
		
				

		if(Email.isEmpty()||Password.isEmpty()||CPassword.isEmpty()||FName.isEmpty()||LName.isEmpty())
		{
			value = false;
			assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");

		}
		else
		{
			WebDriverWait element = new WebDriverWait(driver, 20);
			//checkAlert();
			if( Password.length()<6 ||CPassword.length()<6 )
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("passwordalert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
				System.out.println("dispalyed pass");

			}		
			if((Password != CPassword) )
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("passwordalert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
				System.out.println("dispalyed email");

			}

			if(q1Value.equals(q2Value))
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("securityQuestion1Alert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
				assertTrue(RegisterPage.securityQuestion1Alert(driver).isDisplayed());
				System.out.println("dispalyed q1");


			}
			if(q2Value.equals(q3Value))
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("securityQuestion2Alert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
					assertTrue(RegisterPage.securityQuestion2Alert(driver).isDisplayed());
					System.out.println("dispalyed q2");


			}
			if(q3Value.equals(q1Value))
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("securityQuestion3Alert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
						assertTrue(RegisterPage.securityQuestion3Alert(driver).isDisplayed());
						System.out.println("dispalyed q3");
							

			}
			if(a1value.isEmpty())
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("securityAnswer1Alert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
						//assertTrue(RegisterPage.securityQuestion1Alert(driver).isDisplayed());
							assertTrue(RegisterPage.securityAnswer1Alert(driver).isDisplayed());
							System.out.println("dispalyed a1");
			}
			if(a2value.isEmpty())
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("securityAnswer2Alert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
						//assertTrue(RegisterPage.securityQuestion1Alert(driver).isDisplayed());
							assertTrue(RegisterPage.securityAnswer2Alert(driver).isDisplayed());
							System.out.println("dispalyed a2");
			}
			if(a3value.isEmpty())
			{
				value = false;
				element.until(
				        ExpectedConditions.presenceOfElementLocated(By.id("securityAnswer3Alert")));
				assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
						//assertTrue(RegisterPage.securityQuestion1Alert(driver).isDisplayed());
							assertTrue(RegisterPage.securityAnswer3Alert(driver).isDisplayed());
							System.out.println("dispalyed a3");
			}
			
			if(role.contains("Instructor"))
			{
				value = false;
				assertEquals(depatment.length()>0, true);			
				
				
			}
			if(value == true)
			{
				if(role.contains("Student"))
				assertEquals(driver.getCurrentUrl().contains("StudentHome"),true );
				if(role.contains("Instructor"))
				assertEquals(driver.getCurrentUrl().contains("StudentHome"),true );		
				
			}
		}
	}
	public void checkAlert()
	{		
		
		if(driver.findElement(By.id("emailidalert")).isDisplayed())
		{
			value=false;
			WebDriverWait element = new WebDriverWait(driver, 20);
			element.until(
			        ExpectedConditions.presenceOfElementLocated(By.id("emailidalert")));
			System.out.println("got email lets see");
			assertEquals(driver.getCurrentUrl(), "http://localhost/wechart/public/register");
		}

	}	
	
	
	public void sendRegisterVlaues()
	{
		System.out.println("got here to get elemets");
		//return registerValues;
		
	}

//	@AfterClass
//	public void closeBrowser()
//	{
//		driver.close();
//	}


}