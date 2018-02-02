package Tests;
import Repos.*;
import org.testng.annotations.Test;
import org.testng.annotations.DataProvider;
import org.testng.annotations.BeforeTest;
import java.util.*;

import static org.testng.Assert.assertEquals;

import java.io.FileInputStream;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDateTime;

import org.apache.commons.io.filefilter.RegexFileFilter;
import org.apache.commons.lang3.StringUtils;
import org.apache.commons.lang3.time.DateUtils;
import org.apache.poi.ss.usermodel.DataFormatter;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.AfterTest;

public class AddNewPatient  {

	static XSSFWorkbook workBook; 
	static XSSFSheet sheet;
	static XSSFRow row;
	static int i=0;
	static int j=0;
	static Object[][] DataCellValues;
	WebDriver driver;

	String regexN = "^\\D";
	SimpleDateFormat sd = new SimpleDateFormat("YYYY-MM-DD");
	private boolean Value;





	@DataProvider(name="ap")
	public static Object[][] dataInputFromExcel() throws Exception
	{
		FileInputStream fs = new FileInputStream("C:\\\\Users\\\\astri\\\\Desktop\\\\logindata.xlsx");
		workBook = new XSSFWorkbook(fs);
		sheet = workBook.getSheet("AddPatient");

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

	@Test(dataProvider="ap")
	public void assignValues(String Username,String password,String currentDate,String Gender,String module,String roomNo,
			String age,String height,String hunit,String weight,String wUnit,
			String date,String value) throws Throwable
	{
		driver = new FirefoxDriver();
		Thread.sleep(5000);
		LoginPage.GoToPage(driver);
		LoginPage.UserName(driver).sendKeys(Username);
		LoginPage.Password(driver).sendKeys(password);
		LoginPage.Submit(driver).click();
		driver.findElement(By.id("addPatient")).click();
		if(Gender.contains("Male"))
		{
			AddNewPatientPage.MaleRadioButton(driver).click();

		}
		else
		{
			AddNewPatientPage.FemaleRadioButton(driver).click();
		}


		Thread.sleep(5000);
		System.out.println("1"+module+"3");
		//AddNewPatientPage.FemaleRadioButton(driver).click();
		System.out.println("module");
		Select se = new Select(AddNewPatientPage.ModuleDropdown(driver));
		se.selectByValue(module);

		AddNewPatientPage.ageTextBox(driver).sendKeys(age);
		AddNewPatientPage.heightTextBox(driver).sendKeys(height);
		System.out.println("hunit");
		Select se1 = new Select(AddNewPatientPage.heightUnitDropDown(driver));		
		se1.selectByValue(hunit);

		AddNewPatientPage.weightTextBox(driver).sendKeys(weight);
		System.out.println("wunit");
		Select se2 = new Select(AddNewPatientPage.weightUnitDropDown(driver));		
		se2.selectByValue(wUnit);

		AddNewPatientPage.VisitDateTextBox(driver).sendKeys(date);
		AddNewPatientPage.roomNumber(driver).sendKeys(roomNo);
		AddNewPatientPage.Submit(driver).click();





		if(age.isEmpty()||height.isEmpty()||weight.isEmpty()||date.isEmpty()||roomNo.isEmpty())
		{
			assertEquals(driver.getCurrentUrl().contains("/add_patient"), true);
			return;
		}
		else
		{
			
			//check fo module is not done

			try {
				int x = Integer.parseInt(age); 

				System.out.println("Valid input");
			}catch(NumberFormatException e) {
				System.out.println("age");
				Value=true;
				//assertEquals(driver.getCurrentUrl(), "http://wechart-test.herokuapp.com/add_patient");
				assertEquals(AddNewPatientPage.alert(driver).isDisplayed(), true);
				return;

			} 


			try {
				int x = Integer.parseInt(weight); 

				System.out.println("Valid input");
			}catch(NumberFormatException e) {

				System.out.println("weight");
				Value=true;
				//assertEquals(driver.getCurrentUrl(), "http://wechart-test.herokuapp.com/add_patient");
				assertEquals(AddNewPatientPage.alert(driver).isDisplayed(), true);
				return;
			} 
			try {
				int x = Integer.parseInt(weight); 

				System.out.println("Valid input");
			}catch(NumberFormatException e) {

				System.out.println("height");
				Value=true;
				//assertEquals(driver.getCurrentUrl(), "http://wechart-test.herokuapp.com/add_patient");
				assertEquals(AddNewPatientPage.alert(driver).isDisplayed(), true);
				return;
			} 


			//check the date format
			if(!(date.charAt(4)=='-')|| !(date.charAt(7) =='-'))
			{
				System.out.println("date formet");
				Value=true;
				//assertEquals(driver.getCurrentUrl(), "http://wechart-test.herokuapp.com/add_patient");
				assertEquals(AddNewPatientPage.alert(driver).isDisplayed(), true);
				return;
			}
			//check if date is greater than current date
			if(date.compareTo(currentDate)>0)
			{
				System.out.println("date");
				Value=true;
				//assertEquals(driver.getCurrentUrl(), "http://wechart-test.herokuapp.com/add_patient");
				assertEquals(AddNewPatientPage.alert(driver).isDisplayed(), true);
				return;
			}
			if(Value==(false))
			{
				if(Gender.contains("Male"))
				{
					assertEquals(vitalSignsSectionPage.nameDemo(driver).getText().contains("John"), true);
					assertEquals(driver.getCurrentUrl().contains("Demographics"), true);
					assertEquals(vitalSignsSectionPage.ageDemo(driver).getText(), age);
					assertEquals(vitalSignsSectionPage.sexDemo(driver).getText(), Gender);
					assertEquals(vitalSignsSectionPage.visitDate(driver).getText(), date);
					return;
				}
				if(Gender.contains("Female"))
				{
					assertEquals(vitalSignsSectionPage.nameDemo(driver).getText().contains("Jane"), true);
					assertEquals(driver.getCurrentUrl().contains("Demographics"), true);
					assertEquals(vitalSignsSectionPage.ageDemo(driver).getText(), age);
					assertEquals(vitalSignsSectionPage.sexDemo(driver).getText(), Gender);
					assertEquals(vitalSignsSectionPage.visitDate(driver).getText(), date);
					return;
				}

			}

			driver.close();

		}


	}












}